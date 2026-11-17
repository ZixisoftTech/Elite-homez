-- Migration: Add luxury dossier fields to properties table
-- Date: 2026-09-12

ALTER TABLE properties
    ADD COLUMN IF NOT EXISTS mandate_ref VARCHAR(100) NULL AFTER slug,
    ADD COLUMN IF NOT EXISTS rera_number VARCHAR(100) NULL DEFAULT 'DLRERA2023A00892' AFTER mandate_ref,
    ADD COLUMN IF NOT EXISTS sub_title VARCHAR(255) NULL AFTER title,
    ADD COLUMN IF NOT EXISTS orientation VARCHAR(100) NULL AFTER floor_info,
    ADD COLUMN IF NOT EXISTS ceiling_height VARCHAR(50) NULL AFTER orientation,
    ADD COLUMN IF NOT EXISTS architect_info VARCHAR(150) NULL AFTER ceiling_height,
    ADD COLUMN IF NOT EXISTS coordinates VARCHAR(100) NULL AFTER google_map_url,
    ADD COLUMN IF NOT EXISTS provenance_quote TEXT NULL AFTER description,
    ADD COLUMN IF NOT EXISTS lifestyle_quote TEXT NULL AFTER provenance_quote;
