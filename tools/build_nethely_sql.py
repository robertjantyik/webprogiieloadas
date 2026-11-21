from pathlib import Path
import csv

ROOT = Path(__file__).resolve().parents[1]
DATA = ROOT / "database" / "seeders" / "data"
OUT = ROOT / "database" / "nethely-import.sql"


def rows(name):
    with (DATA / name).open(encoding="utf-8", newline="") as file:
        return list(csv.reader(file, delimiter="\t"))[1:]


def quote(value):
    return "'" + value.replace("'", "''") + "'"


sql = [
    "-- ReNew Nethely import. Import into an empty MySQL database with phpMyAdmin.",
    "SET NAMES utf8mb4;",
    "SET FOREIGN_KEY_CHECKS=0;",
    "CREATE TABLE IF NOT EXISTS users (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL UNIQUE, role TINYINT UNSIGNED NOT NULL DEFAULT 2, email_verified_at TIMESTAMP NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) NULL, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    "CREATE TABLE IF NOT EXISTS processors (id INT UNSIGNED NOT NULL PRIMARY KEY, manufacturer VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    "CREATE TABLE IF NOT EXISTS operating_systems (id INT UNSIGNED NOT NULL PRIMARY KEY, name VARCHAR(255) NOT NULL, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    "CREATE TABLE IF NOT EXISTS notebooks (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, manufacturer VARCHAR(100) NOT NULL, model VARCHAR(160) NOT NULL, screen_size DECIMAL(4,1) NOT NULL, memory_mb SMALLINT UNSIGNED NOT NULL, disk_gb SMALLINT UNSIGNED NOT NULL, graphics VARCHAR(255) NOT NULL, price INT UNSIGNED NOT NULL, processor_id INT UNSIGNED NOT NULL, operating_system_id INT UNSIGNED NOT NULL, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, INDEX notebooks_price_index (price), CONSTRAINT notebooks_processor_fk FOREIGN KEY (processor_id) REFERENCES processors(id), CONSTRAINT notebooks_os_fk FOREIGN KEY (operating_system_id) REFERENCES operating_systems(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    "CREATE TABLE IF NOT EXISTS messages (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, user_id BIGINT UNSIGNED NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, body TEXT NOT NULL, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, CONSTRAINT messages_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    "CREATE TABLE IF NOT EXISTS migrations (id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) NOT NULL, batch INT NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    "INSERT IGNORE INTO migrations (migration,batch) VALUES ('0001_01_01_000000_create_users_table',1),('0001_01_01_000001_create_cache_table',1),('0001_01_01_000002_create_jobs_table',1),('2026_11_21_000001_add_role_to_users_table',1),('2026_11_21_000002_create_catalog_and_messages_tables',1);",
]

now = "CURRENT_TIMESTAMP"
for row in rows("processzor.txt"):
    sql.append(f"INSERT IGNORE INTO processors (id,manufacturer,model,created_at,updated_at) VALUES ({int(row[0])},{quote(row[1])},{quote(row[2])},{now},{now});")
for row in rows("oprendszer.txt"):
    sql.append(f"INSERT IGNORE INTO operating_systems (id,name,created_at,updated_at) VALUES ({int(row[0])},{quote(row[1])},{now},{now});")
for notebook_id, row in enumerate(rows("gep.txt"), start=1):
    screen = row[2].replace(",", ".")
    sql.append(f"INSERT IGNORE INTO notebooks (id,manufacturer,model,screen_size,memory_mb,disk_gb,graphics,price,processor_id,operating_system_id,created_at,updated_at) VALUES ({notebook_id},{quote(row[0])},{quote(row[1])},{screen},{int(row[3])},{int(row[4])},{quote(row[5])},{int(row[6])},{int(row[7])},{int(row[8])},{now},{now});")

# Seeded development admin: admin@renew.local / admin12345
admin_hash = "$2y$10$kIgB5sJOa/Z9E4u1V92nKOMsPo7LauAyetAqC7Tv47WES8qXQGJhm"
sql.append(f"INSERT IGNORE INTO users (id,name,email,role,password,created_at,updated_at) VALUES (1,'Admin','admin@renew.local',1,'{admin_hash}',{now},{now});")
sql.extend(["SET FOREIGN_KEY_CHECKS=1;", ""])
OUT.write_text("\n".join(sql), encoding="utf-8")
print(f"Wrote {OUT} with {len(sql) - 10} data inserts.")
