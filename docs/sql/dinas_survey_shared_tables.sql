-- ============================================================
-- TABEL BERSAMA UNTUK CACHE SURVEI DI 3 WEBSITE DINAS
-- ============================================================
-- Dijalankan di database MySQL yang SAMA dengan E-Survey
-- (default: db_survey_deliserdang22).
--
-- PENTING: tabel ini BUKAN pengganti tabel milik E-Survey
-- (survey_templates, survey_responses, dst -- itu tetap dikelola
-- Laravel/Eloquent sepenuhnya). Ini tabel terpisah yang dipakai
-- backend Node.js tiap dinas (Dinsos/Damkar/Disparbud) sebagai
-- "cache lokal" dari data yang MEREKA TERIMA lewat API push/webhook
-- E-Survey -- supaya ketiga backend Node tidak lagi menyimpan data
-- ke file JSON/SQLite masing-masing, melainkan ke MySQL yang sama.
--
-- Kolom `sumber_dinas` memisahkan data antar dinas di dalam tabel
-- yang sama (dinsos / damkar / disparbud), sehingga 1 pasang tabel
-- ini dipakai bersama oleh ketiganya.
--
-- Alur datanya TETAP lewat API seperti sebelumnya:
--   E-Survey --push--> POST {api_base_url}/survey  --> INSERT/UPDATE dinas_survey_cache
--   Pengunjung --submit--> POST /api/survey/:kode/jawaban --> INSERT dinas_survey_jawaban
--                                                            --> lalu backend Node kirim webhook ke E-Survey (seperti sebelumnya)

CREATE TABLE IF NOT EXISTS dinas_survey_cache (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  sumber_dinas VARCHAR(30) NOT NULL COMMENT 'dinsos | damkar | disparbud',
  kode_survei VARCHAR(100) NOT NULL,
  judul_survei VARCHAR(255) NOT NULL,
  status VARCHAR(20) NULL,
  payload_json JSON NOT NULL COMMENT 'payload lengkap dari E-Survey: pertanyaan, field_data_diri, popup, dst',
  diterima_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  diperbarui_pada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_dinas_kode (sumber_dinas, kode_survei)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS dinas_survey_jawaban (
  id CHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID',
  sumber_dinas VARCHAR(30) NOT NULL COMMENT 'dinsos | damkar | disparbud',
  kode_survei VARCHAR(100) NOT NULL,
  judul_survei VARCHAR(255) NULL,
  nama_responden VARCHAR(150) NULL,
  email VARCHAR(150) NULL,
  no_hp VARCHAR(30) NULL,
  data_tambahan_json JSON NULL,
  jawaban_json JSON NOT NULL,
  waktu DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status_kirim_esurvey VARCHAR(20) NOT NULL DEFAULT 'belum_dikirim' COMMENT 'belum_dikirim | terkirim | gagal',
  esurvey_response_json JSON NULL,
  KEY idx_dinas_kode (sumber_dinas, kode_survei)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
