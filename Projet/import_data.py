import csv
import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="zapkartenn"
)
cursor = conn.cursor()

def safe_int(val):
    """Convertit en int ou retourne None."""
    try:
        return int(float(val)) if val and str(val).strip() else None
    except:
        return None

def safe_bool(val):
    """Convertit 'true'/'false'/'1'/'0' en booléen."""
    if val and str(val).strip().lower() in ('true', '1', 'oui'):
        return True
    return False

def safe_decimal(val):
    """Convertit en float ou None."""
    try:
        return float(str(val).strip()) if val and str(val).strip() else None
    except:
        return None

# IMPORT COMMUNE
print("Import des communes...")
with open('communes-france-2024-limite.csv', encoding='utf-8') as f:
    reader = csv.DictReader(f, delimiter=';')
    communes_existantes = set()
    for row in reader:
        code = row.get('code_insee', '').strip()
        if not code or code in communes_existantes:
            continue
        communes_existantes.add(code)
        cursor.execute("""
            INSERT IGNORE INTO COMMUNE (code_insee, nom, code_postal, population, dep_nom)
            VALUES (%s, %s, %s, %s, %s)
        """, (
            code,
            row.get('nom_standard', row.get('nom', '')).strip(),
            row.get('code_postal', '').strip(),
            safe_int(row.get('population', '')),
            row.get('dep_nom', '').strip()
        ))

conn.commit()
print(f"  → {len(communes_existantes)} communes insérées")

# IMPORT IRVE
print("Import des données IRVE...")

amenageurs_vus   = {}
operateurs_vus   = {}
stations_existantes = set()
nb_stations_inserees = 0
nb_pdc = 0

with open('irve_init.csv', encoding='utf-8') as f:
    reader = csv.DictReader(f, delimiter=',')
    
    for row in reader:

        siren = row.get('siren_amenageur', '').strip()
        if siren and siren not in amenageurs_vus:
            cursor.execute("""
                INSERT IGNORE INTO AMENAGEUR (siren, nom, contact)
                VALUES (%s, %s, %s)
            """, (
                siren,
                row.get('nom_amenageur', '').strip(),
                row.get('contact_amenageur', '').strip()
            ))
            amenageurs_vus[siren] = True

        nom_op = row.get('nom_operateur', '').strip()
        id_operateur = None
        if nom_op:
            if nom_op not in operateurs_vus:
                cursor.execute("""
                    INSERT INTO OPERATEUR (nom, contact, telephone)
                    VALUES (%s, %s, %s)
                """, (
                    nom_op,
                    row.get('contact_operateur', '').strip(),
                    row.get('telephone_operateur', '').strip()
                ))
                operateurs_vus[nom_op] = cursor.lastrowid
            id_operateur = operateurs_vus.get(nom_op)

        id_station = row.get('id_station_itinerance', '').strip()
        if not id_station:
            id_station = row.get('id_station_local', '').strip()
            
        code_insee = row.get('code_insee_commune', '').strip()
        
        if code_insee and code_insee not in communes_existantes:
            code_insee = None

        if id_station:
            if id_station not in stations_existantes:
                lng = safe_decimal(row.get('consolidated_longitude', ''))
                lat = safe_decimal(row.get('consolidated_latitude', ''))
                
                try:
                    cursor.execute("""
                        INSERT IGNORE INTO STATION
                            (id_station, id_local, nom_station, nom_enseigne,
                             implantation, adresse, horaires, raccordement,
                             date_mise_en_service, longitude, latitude,
                             code_insee, siren)
                        VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)
                    """, (
                        id_station,
                        row.get('id_station_local', '').strip(),
                        row.get('nom_station', '').strip(),
                        row.get('nom_enseigne', '').strip(),
                        row.get('implantation_station', '').strip(),
                        row.get('adresse_station', '').strip(),
                        row.get('horaires', '').strip(),
                        row.get('raccordement', '').strip(),
                        row.get('date_mise_en_service', '').strip(),
                        lng,
                        lat,
                        code_insee if code_insee else None,
                        siren if siren else None
                    ))
                    stations_existantes.add(id_station)
                    nb_stations_inserees += 1
                except Exception as e:
                    print(f"Erreur lors de l'insertion de la station {id_station}: {e}")
                    continue

            if id_station in stations_existantes:
                prise_ef_val = 1 if safe_bool(row.get('prise_type_ef', '')) else 0
                prise_t2_val = 1 if safe_bool(row.get('prise_type_2', '')) else 0

                cursor.execute("""
                    INSERT INTO POINT_DE_CHARGE
                        (puissance_nominale, prise_ef, prise_t2,
                         prise_type_ccs, chademo,
                         gratuit, paiement, tarification, id_station)
                    VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)
                """, (
                    safe_int(row.get('puissance_nominale', '')),
                    prise_ef_val,
                    prise_t2_val,
                    safe_bool(row.get('prise_type_combo_ccs', '')),
                    safe_bool(row.get('prise_type_chademo', '')),
                    row.get('gratuit', '').strip(),
                    row.get('paiement_acte', '').strip(),
                    row.get('tarification', '').strip(),
                    id_station
                ))
                id_pdc = cursor.lastrowid
                nb_pdc += 1

                if id_pdc and id_operateur:
                    cursor.execute("""
                        INSERT IGNORE INTO OPERE (id_pdc, id_operateur)
                        VALUES (%s, %s)
                    """, (id_pdc, id_operateur))

conn.commit()
print(f"  → {nb_stations_inserees} stations insérées")
print(f"  → {nb_pdc} points de charge insérés")
print(f"  → {len(operateurs_vus)} opérateurs insérés")
print(f"  → {len(amenageurs_vus)} aménageurs insérés")

cursor.close()
conn.close()
print("\n Import terminé avec succès !")