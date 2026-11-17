# Elite Homez — Bespoke South Delhi Luxury Real Estate Platform

> **"your trust, our responsibility."**

Elite Homez is an independent bespoke property advisory platform orchestrating the acquisition, disposition, and structured valuation of premier residential assets and prime generational estates across South Delhi's most prestigious enclaves.

---

## 🏛️ Prime Territories of Expertise
- **Vasant Vihar**
- **Jor Bagh**
- **Golf Links**
- **Chanakyapuri**
- **Panchsheel Park**
- **Shanti Niketan**
- **Anand Niketan**
- **Westend**
- **Hauz Khas**
- **Greater Kailash (GK-1 & GK-2)**
- **Sundar Nagar**
- **Defence Colony**

---

## 💎 Key Platform Features
- **Dynamic Content & Layouts:** Fully database-driven Home, Services, Locations, Properties, Testimonials, Carousel, and Global Settings.
- **Dynamic Location Dossiers:** Micro-market intelligence, typical property formats, spatial typology plot size benchmarks, connectivity corridors, neighborhood lifestyle ambiance, and FAQ accordions.
- **Curated Property Portfolio:** Filterable by transaction mandate (*For Sale*, *For Rent*), category, price, and enclave, with featured residence badges.
- **Private Advisory Enquiry Desks:** Dynamic confidential briefing forms with anti-spam honeypot defense, CSRF protection, and AJAX submission.
- **Unique Mandate Reference Tracking:** Inbound enquiries generate unique reference IDs (e.g. `#EH-00042`) with timestamps in Indian Standard Time (IST).
- **Automated Transactional Notifications:** Integrated Mailer sending HTML dossiers to `info@elitehomez.com` with direct WhatsApp and Call links.
- **Sticky WhatsApp Concierge:** Responsive direct connect widget linked to `+91 9811044200`.
- **Comprehensive Admin Control Suite:** RBAC-protected backend for managing properties, areas, services, hero carousels, testimonials, enquiries, and brand settings.

---

## 🛠️ Technology Stack
- **Backend:** Pure PHP (Custom MVC architecture, strict typing, PSR-4 autoloading)
- **Database:** MySQL / MariaDB (PDO, prepared statements)
- **Frontend:** Tailwind CSS, Custom Luxury Design System, Google Fonts (*Playfair Display*, *Cinzel*, *Manrope*, *Plus Jakarta Sans*)
- **Routing:** Front-controller pattern with clean URL rewriting (`router.php` / `.htaccess`)
- **Security:** CSRF validation, XSS escaping, Session regeneration, brute-force login lockout, honeypot spam traps

---

## 🚀 Installation & Local Setup

1. **Clone Repository:**
   ```bash
   git clone https://github.com/ZixisoftTech/Elite-homez.git
   cd Elite-homez
   ```

2. **Database Setup:**
   - Import the complete database export into MySQL:
     ```bash
     mysql -u root -p elite_homez < database/full_export_elite_homez.sql
     ```
   - Verify database configuration in `app/Config/database.php`.

3. **Start Development Server:**
   ```bash
   php -S 127.0.0.1:8000 router.php
   ```

4. **Access Platform:**
   - **Public Website:** `http://127.0.0.1:8000/`
   - **Admin Control Panel:** `http://127.0.0.1:8000/admin/login`

---

## 🧪 Testing & Quality Assurance
Run the master regression QA test suite:
```bash
php tests/full_regression_qa.php
```
*Current test coverage: 251 / 251 tests passing (100% clean pass).*

---

## 📞 Official Advisory Contact
- **Address:** 225, 2nd Floor, Square One Mall, Saket, New Delhi - 110017 (India)
- **Direct Telephone:** +91 9811044200 | +91 98112 88400
- **WhatsApp Concierge:** +91 98110 44200
- **Email:** info@elitehomez.com
- **RERA Registration:** DLRERA2023A00892
