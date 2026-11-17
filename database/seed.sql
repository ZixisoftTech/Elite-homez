-- ============================================================
-- ELITE HOMEZ — COMPREHENSIVE SEED DATA
-- Master Amenities, Areas of Expertise, Services, Sample Listings & Settings
-- ============================================================

-- 1. Default Admin User
-- Password: Admin@112233
INSERT INTO admins (name, email, password_hash, role) VALUES
('Principal Administrator', 'admin@elitehomez.com', '$2y$12$rE7rqe1ITVqWCqAqret9POB0BN4BvSqRiwZK4KEEWlhMk7zx3O1ui', 'admin');

-- 2. Master Features & Amenities Library (45+ items)
INSERT INTO features (name, slug, icon, status, sort_order) VALUES
('Swimming Pool', 'swimming-pool', 'waves', 'active', 1),
('Landscaped Garden', 'landscaped-garden', 'trees', 'active', 2),
('Private Terrace', 'private-terrace', 'sun', 'active', 3),
('High-Speed Lift', 'high-speed-lift', 'arrow-up-circle', 'active', 4),
('Dedicated Stilt Parking', 'dedicated-stilt-parking', 'car', 'active', 5),
('100% Power Backup', 'power-backup', 'zap', 'active', 6),
('24x7 Gated Security', '24x7-security', 'shield', 'active', 7),
('CCTV Surveillance', 'cctv-surveillance', 'video', 'active', 8),
('Private Gymnasium', 'gymnasium', 'activity', 'active', 9),
('Home Theatre', 'home-theatre', 'film', 'active', 10),
('Italian Modular Kitchen', 'modular-kitchen', 'utensils', 'active', 11),
('Staff / Servant Quarters', 'servant-room', 'users', 'active', 12),
('Dedicated Driver Room', 'driver-room', 'user-check', 'active', 13),
('Study Room & Library', 'study-room', 'book-open', 'active', 14),
('Pooja Room', 'pooja-room', 'feather', 'active', 15),
('Walk-in Closets', 'walk-in-closet', 'maximize', 'active', 16),
('Central Air Conditioning (VRV)', 'central-ac', 'wind', 'active', 17),
('Natural Fireplace', 'fireplace', 'flame', 'active', 18),
('Private Jacuzzi', 'jacuzzi', 'droplet', 'active', 19),
('Steam & Sauna Room', 'steam-room', 'cloud', 'active', 20),
('Smart Home Automation', 'smart-home', 'cpu', 'active', 21),
('Video Door Phone & Intercom', 'video-door-phone', 'phone-call', 'active', 22),
('Gated Luxury Community', 'gated-community', 'lock', 'active', 23),
('Dedicated Visitor Parking', 'visitor-parking', 'map-pin', 'active', 24),
('Pet Friendly', 'pet-friendly', 'heart', 'active', 25),
('High Ceilings (12ft+)', 'high-ceilings', 'move', 'active', 26),
('Floor-to-Ceiling Windows', 'floor-to-ceiling-windows', 'grid', 'active', 27),
('Abundant Natural Light', 'natural-light', 'sun', 'active', 28),
('Private Rooftop Lounge', 'rooftop-lounge', 'coffee', 'active', 29),
('Wrap-around Balconies', 'balcony', 'layout', 'active', 30),
('Dedicated Laundry & Utility', 'laundry-room', 'repeat', 'active', 31),
('EV Charging Station', 'ev-charging', 'battery-charging', 'active', 32),
('Solar Energy Integration', 'solar-power', 'sun', 'active', 33),
('Multi-Tier Water Filtration', 'water-storage', 'server', 'active', 34),
('Rainwater Harvesting', 'rainwater-harvesting', 'cloud-rain', 'active', 35),
('Temperature Controlled Wine Cellar', 'wine-cellar', 'archive', 'active', 36),
('Double-Height Living Salon', 'double-height-living', 'box', 'active', 37),
('Italian Statuario Marble Flooring', 'italian-marble', 'square', 'active', 38),
('Acoustic Double-Glazed Windows', 'soundproof-windows', 'volume-x', 'active', 39),
('Private Elevator Lobby', 'private-elevator', 'chevrons-up', 'active', 40),
('Clubhouse Access', 'club-house', 'home', 'active', 41),
('Fully Furnished', 'fully-furnished', 'award', 'active', 42),
('Semi Furnished', 'semi-furnished', 'check-square', 'active', 43),
('Vaastu Compliant Design', 'vaastu-compliant', 'compass', 'active', 44),
('Ultra-High Speed Fiber Ready', 'fiber-ready', 'wifi', 'active', 45);

-- 3. Initial Areas of Expertise (8 South Delhi & Prime Delhi Enclaves)
INSERT INTO areas (name, slug, short_description, detailed_description, property_info, connectivity, nearby_landmarks, hero_image, map_url, is_published, sort_order, seo_title, meta_description) VALUES
('Vasant Vihar', 'vasant-vihar', 'A premier diplomatic and residential enclave known for wide tree-lined boulevards and high-value architectural bungalows.',
'Vasant Vihar stands as one of the capital\'s most prestigious addresses. Originally established for foreign diplomatic missions and distinguished civil servants, the enclave today represents the pinnacle of refined residential living. Characterized by wide roads, deep building setbacks, private security barricades, and verdant private parks, Vasant Vihar offers an exclusive living environment that marries central accessibility with tranquil privacy.',
'Primarily comprises independent multi-storey luxury builder floors on plot sizes ranging from 400 to 1,200 square yards, alongside expansive legacy bungalows and modern freehold redevelopment estates.',
'Direct connectivity via Outer Ring Road, Nelson Mandela Marg, and Rao Tula Ram Marg. 15 minutes to Indira Gandhi International Airport (Terminal 3) and Aerocity commercial district.',
'Vasant Vihar Club, Basant Lok Community Centre, PVR Priya Complex, prestigious diplomatic embassies, elite international schools.',
'/assets/images/areas/vasant-vihar.jpg', 'https://maps.google.com/?q=Vasant+Vihar+New+Delhi', 1, 1,
'Luxury Properties in Vasant Vihar | Elite Homez Advisory',
'Explore exclusive luxury bungalows, builder floors, and freehold residential properties in Vasant Vihar, New Delhi with Elite Homez property advisors.'),

('Jor Bagh', 'jor-bagh', 'A rare, low-density heritage residential sanctuary overlooking Lodi Gardens and historical monuments.',
'Jor Bagh is renowned as one of Delhi\'s quietest and most aristocratic residential enclaves. Bordering the historic Lodi Gardens and Safdarjung Tomb, properties here command exceptional prestige owing to strict zoning regulations, low vehicular density, and majestic foliage that surrounds every residence.',
'Features classic freehold bungalows and bespoke newly constructed luxury floors on plot sizes typically measuring 375 to 800 square yards with direct garden and park views.',
'Immediate access to Lodhi Road, Aurobindo Marg, and Max Mueller Marg. 5 minutes to Khan Market, 10 minutes to Central Secretariat and India Gate.',
'Lodi Gardens, India Habitat Centre, Safdarjung Tomb, Khan Market, Delhi Golf Club.',
'/assets/images/areas/jor-bagh.jpg', 'https://maps.google.com/?q=Jor+Bagh+New+Delhi', 1, 2,
'Prime Real Estate in Jor Bagh, New Delhi | Elite Homez',
'Curated selection of luxury residences, boutique floors, and private bungalows in Jor Bagh overlooking Lodi Gardens.'),

('Golf Links', 'golf-links', 'An ultra-private enclave directly bordering the prestigious Delhi Golf Club, representing Delhi\'s most coveted real estate.',
'Nestled intimately against the rolling greens of the historic Delhi Golf Club, Golf Links is celebrated for its exclusivity, impeccable gated security, and proximity to the country\'s highest government offices. A haven for industrialists, diplomats, and old-wealth families, it offers an idyllic village-like seclusion right in the heart of Lutyens\' peripheral zone.',
'Bespoke independent residences, ultra-luxury full-floor residences, and legacy estates with private lawns and serene tree-canopied access.',
'Seamless connectivity to Subramaniam Bharti Marg, Dr. Zakir Hussain Marg, and Mathura Road. Minutes away from Delhi Golf Club and Sunder Nursery.',
'Delhi Golf Club, Oberoi New Delhi, Sunder Nursery, Delhi High Court, Khan Market.',
'/assets/images/areas/golf-links.jpg', 'https://maps.google.com/?q=Golf+Links+New+Delhi', 1, 3,
'Exclusive Residences in Golf Links | Elite Homez Luxury Property',
'Acquire confidential and curated luxury properties in Golf Links, New Delhi through Elite Homez property advisory.'),

('Chanakyapuri', 'chanakyapuri', 'The diplomatic capital of India, synonymous with grand foreign embassies, wide avenues, and sovereign tranquility.',
'Chanakyapuri, designed in the 1950s as Delhi\'s official diplomatic quarter, houses embassies, high commissions, and residence quarters of foreign dignitaries. Residential properties in adjoining micro-pockets offer unparalleled security, immaculate municipal upkeep, and sweeping road frontages rarely found in urban metropolitan areas.',
'Distinguished standalone mansions, private diplomat residences, and select bespoke builder floors on expansive plot dimensions.',
'Direct transit along Shantipath, Nyaya Marg, and Sardar Patel Marg, connecting seamlessly to Rashtrapati Bhavan, Central Delhi, and the airport arterial roads.',
'Shantipath Diplomatic Enclave, Nehru Park, The Ashok Hotel, Taj Palace Hotel, ITC Maurya.',
'/assets/images/areas/chanakyapuri.jpg', 'https://maps.google.com/?q=Chanakyapuri+New+Delhi', 1, 4,
'Chanakyapuri Luxury Residential Real Estate | Elite Homez',
'Prestigious residential opportunities in Chanakyapuri diplomatic district. Discreet property guidance with Elite Homez.'),

('Panchsheel Park', 'panchsheel-park', 'A vibrant yet dignified luxury neighborhood split across North and South blocks with premier club amenities.',
'Panchsheel Park is one of South Delhi\'s most sought-after planned residential colonies. Known for its prestigious Panchsheel Club, expansive central roundabouts, and lush neighborhood parks, it offers a harmonious blend of energetic family community life and serene privacy.',
'Modern 4-bedroom and 5-bedroom luxury builder floors with private stilt parking, rooftop terraces, and basement recreational lounges.',
'Strategically positioned along Outer Ring Road and August Kranti Marg with seamless access to Panchsheel Enclave, Hauz Khas, and Greater Kailash.',
'Panchsheel Club, Siri Fort Sports Complex, Ansal Plaza, Hauz Khas District Park.',
'/assets/images/areas/panchsheel-park.jpg', 'https://maps.google.com/?q=Panchsheel+Park+New+Delhi', 1, 5,
'Luxury Properties in Panchsheel Park | Elite Homez',
'Explore luxury builder floors and freehold residences in Panchsheel Park North and South with Elite Homez.'),

('Shanti Niketan', 'shanti-niketan', 'An exclusive colony established for senior executives and scholars, now host to grand modern mansions.',
'Shanti Niketan directly adjoins Westend and Anand Niketan. Famous for wide 60-foot colony roads, underground electrical cabling, and strict round-the-clock entry checkpoints, Shanti Niketan continues to attract corporate leaders, counsel, and prominent families seeking understated luxury.',
'Luxury independent floors featuring private elevators, bespoke Italian finishes, and standalone corner bungalows on 600 to 1,200 square yard plots.',
'Quick connection to Benito Juarez Marg, Ring Road, and Rao Tula Ram Marg.',
'Shanti Niketan Club, proximity to Dhaula Kuan, Delhi Gymkhana Club, and Chanakyapuri.',
'/assets/images/areas/shanti-niketan.jpg', 'https://maps.google.com/?q=Shanti+Niketan+New+Delhi', 1, 6,
'Prime Residences in Shanti Niketan | Elite Homez Property Advisory',
'Discover verified residential builder floors and independent residences in Shanti Niketan with Elite Homez.'),

('Anand Niketan', 'anand-niketan', 'A tranquil residential sanctuary offering quiet streets, park frontages, and contemporary architectural homes.',
'Bordered by the diplomatic enclave and green ridge reserves, Anand Niketan offers residents an exceptional standard of living. It maintains a peaceful residential character with strictly enforced commercial zoning restrictions and manicured community gardens.',
'Boutique residences, park-facing penthouse floors with private terrace gardens, and distinguished modern residential houses.',
'Direct entry via Benito Juarez Marg and proximity to South Campus and Dhaula Kuan interchanges.',
'Anand Niketan Club, Mount Carmel School, proximity to Vasant Vihar commercial hubs.',
'/assets/images/areas/anand-niketan.jpg', 'https://maps.google.com/?q=Anand+Niketan+New+Delhi', 1, 7,
'Curated Real Estate in Anand Niketan | Elite Homez',
'View verified luxury floors and freehold properties for sale and rent in Anand Niketan, New Delhi.'),

('Westend', 'westend', 'Delhi\'s premier gated colony of magnificent high-walled villas, lush greenery, and tight community security.',
'Westend Colony is widely regarded as one of the most private and exclusive residential enclaves in India. Surrounded by dense foliage and guarded by multiple manned security gates, Westend boasts large plot footprints, minimal external transit traffic, and a tranquil suburban serenity minutes from the diplomatic core.',
'Expansive private bungalows and newly minted bespoke luxury floors built on substantial 800 to 1,500 square yard parcels.',
'Immediate gateway to Rao Tula Ram Marg, Outer Ring Road, and Delhi Cantonment.',
'Westend Club, proximity to Diplomatic Enclave, Delhi Golf Club, and international airport.',
'/assets/images/areas/westend.jpg', 'https://maps.google.com/?q=Westend+Colony+New+Delhi', 1, 8,
'Westend Luxury Properties & Bungalows | Elite Homez',
'Exclusive acquisition advisory for private bungalows and luxury residences in Westend Colony, New Delhi.');

-- 4. Initial Advisory Services
INSERT INTO services (name, slug, short_description, content, image, icon, is_published, sort_order, seo_title, meta_description) VALUES
('Luxury Residential Advisory', 'luxury-residential-advisory', 'End-to-end guidance for high-net-worth individuals and families seeking prime residential acquisitions.',
'## Dedicated Luxury Property Advisory\n\nNavigating prime real estate requires seasoned market insight, discretion, and an intimate understanding of micro-market pricing. Elite Homez provides comprehensive advisory for purchasers, investors, and families looking to establish their presence in the capital\'s most distinguished enclaves.\n\n### Our Strategic Process\n1. **Needs Assessment & Confidential Brief**: We capture your spatial, architectural, lifestyle, and privacy requirements.\n2. **Private & Off-Market Portfolio Access**: Leveraging our 20+ years of institutional relationships to present residences before public release.\n3. **Independent Title & Due Diligence Verification**: Rigorous inspection of municipal clearances, freehold titles, and heritage zoning laws.\n4. **Structured Price Negotiation & Closing**: Strategic negotiation safeguarding your capital and closing with total discretion.',
'/assets/images/services/residential-advisory.jpg', 'compass', 1, 1,
'Luxury Residential Property Advisory | Elite Homez',
'Comprehensive advisory for luxury residential property acquisitions in Delhi\'s most prestigious addresses.'),

('Turnkey Property Acquisition', 'turnkey-property-acquisition', 'Seamless facilitation from private viewing through technical inspection, title audit, and legal handover.',
'## Turnkey Property Acquisition Services\n\nAcquiring a premier residential asset should be an effortless experience. Our Turnkey Acquisition service handles every technical, commercial, and administrative dimension on your behalf.\n\n### Scope of Turnkey Advisory\n- **Exhaustive Structural & MEP Audit**: Verification of electrical load, plumbing lines, waterproofing, and structural integrity.\n- **Architectural Feasibility**: Assessing renovation potential, FAR compliance, and interior personalization.\n- **Registry & Stamp Duty Execution**: Complete coordination with local revenue and municipal authorities.\n- **Post-Acquisition Transition**: Coordination with facility management, security protocol setup, and utility transfers.',
'/assets/images/services/turnkey-acquisition.jpg', 'key', 1, 2,
'Turnkey Residential Property Acquisition | Elite Homez',
'Seamless, end-to-end residential acquisition service from initial search to deed execution and physical possession.'),

('Discreet Asset Divestment', 'discreet-asset-divestment', 'Confidential marketing and tailored divestment strategies for generational and high-value properties.',
'## Confidential Divestment & Private Sale\n\nHigh-value residential properties demand marketing discretion. Public listings and price reductions erode asset value. Elite Homez executes private, targeted divestment strategies connecting sellers exclusively with pre-vetted, qualified purchasers.\n\n### Why Divest Through Elite Homez\n- **Zero Unsolicited Exposure**: No open property signs or indiscriminate public portal exposure.\n- **Qualified High-Net-Worth Network**: Immediate access to family offices, enterprise founders, and diplomatic principals.\n- **Defensible Valuation Modeling**: Real-time comparable registry data establishing optimal transactional benchmarks.\n- **Strict Confidentiality Agreements**: Non-disclosure covenants protecting family privacy and financial sensitivity.',
'/assets/images/services/asset-divestment.jpg', 'shield-check', 1, 3,
'Confidential Luxury Property Divestment | Elite Homez',
'Private, discreet marketing and valuation advisory for high-value residential properties and family estates.'),

('Ultra-High-Net-Worth Advisory', 'uhnw-advisory', 'Specialized bespoke counsel for multi-property portfolios, estate restructuring, and legacy acquisitions.',
'## Bespoke UHNW Real Estate Solutions\n\nFamily offices and ultra-high-net-worth principals require an advisory partner with the sophistication to handle multi-generational estates, corporate ownership structures, and high-stakes capital allocations.\n\n### Dedicated Family Office Solutions\n- **Multi-Property Portfolio Review**: Asset performance auditing and spatial reallocation strategies.\n- **Estate Succession & Demarcation Guidance**: Assisting families in structuring asset distribution and redevelopment.\n- **Diplomatic & Corporate Leasing**: Curating institutional tenancy agreements with accredited embassies and multinational heads.\n- **Direct Principal-to-Principal Representation**: Direct engagement with decision-makers, eliminating speculative intermediaries.',
'/assets/images/services/uhnw-advisory.jpg', 'briefcase', 1, 4,
'UHNW Real Estate Advisory & Family Office Solutions | Elite Homez',
'Specialized property advisory for family offices, enterprise leaders, and institutional clients.');

-- 5. Curated Luxury Properties
INSERT INTO properties (area_id, title, slug, property_type, listing_type, price, price_display, property_size, plot_size, bedrooms, bathrooms, parking_spaces, floor_info, property_location, google_map_url, description, featured_image, is_featured, status, sort_order, seo_title, meta_description) VALUES
(1, 'The Diplomatic Boulevard Villa', 'the-diplomatic-boulevard-villa-vasant-vihar', 'Independent Luxury Bungalow', 'sale', 385000000.00, '₹38.50 Cr', '9,500 Sq. Ft.', '800 Sq. Yds.', 6, 7, 5, 'Ground + 2 Floors + Basement', 'Block A, Vasant Vihar, New Delhi', 'https://maps.google.com/?q=Block+A+Vasant+Vihar+New+Delhi',
'An architectural tour-de-force positioned along one of Vasant Vihar\'s widest and most private tree-canopied avenues. This standalone estate features soaring 13-foot ceilings, an expansive double-height grand living salon, a private heated indoor pool, an elevator serving all levels, and a landscaped rooftop lounge with panoramic tree-top views. Designed for generational living and diplomatic-scale hosting, the residence includes a fully appointed Italian modular show kitchen, secondary prep kitchen, and dedicated staff quarters for four attendants.',
'/assets/images/properties/villa-vasant-vihar.jpg', 1, 'published', 1,
'Independent Luxury Villa for Sale in Vasant Vihar | Elite Homez',
'Exquisite 6 BHK independent bungalow on 800 sq. yds. in Vasant Vihar with private pool, elevator, and sprawling garden.'),

(2, 'The Heritage Park Residence', 'the-heritage-park-residence-jor-bagh', 'Ground Floor with Basement & Garden', 'sale', 290000000.00, '₹29.00 Cr', '6,200 Sq. Ft.', '575 Sq. Yds.', 4, 5, 4, 'Ground Floor + Finished Basement', 'Lane 8, Jor Bagh, New Delhi', 'https://maps.google.com/?q=Jor+Bagh+New+Delhi',
'Overlooking the serene green buffer of Lodi Gardens, this masterfully curated ground-floor residence combines heritage proportions with state-of-the-art contemporary interior architecture. Featuring an exclusive 1,800 sq. ft. private manicured lawn, floor-to-ceiling soundproof acoustic glazing, and an entertainment basement complete with a temperature-controlled wine cellar and personal cinema salon.',
'/assets/images/properties/residence-jor-bagh.jpg', 1, 'published', 2,
'Luxury Garden Floor in Jor Bagh | Elite Homez',
'Exclusive 4 BHK ground floor residence with private lawn and entertainment basement in Jor Bagh, New Delhi.'),

(3, 'The Fairway Penthouse', 'the-fairway-penthouse-golf-links', 'Duplex Penthouse with Private Terrace', 'sale', 420000000.00, '₹42.00 Cr', '7,800 Sq. Ft.', '650 Sq. Yds.', 5, 6, 4, 'Third Floor + Private Terrace', 'Main Avenue, Golf Links, New Delhi', 'https://maps.google.com/?q=Golf+Links+New+Delhi',
'An ultra-rare offering in Delhi\'s most exclusive residential address. This duplex penthouse commands uninterrupted fairway vistas across the lush canopy of the Delhi Golf Club. Boasting a private glass-encased rooftop pool, sundeck pavilion, seamless home automation, and an exclusive private elevator lobby accessed directly from stilt parking.',
'/assets/images/properties/penthouse-golf-links.jpg', 1, 'published', 3,
'Golf Links Duplex Penthouse with Golf Views | Elite Homez',
'Premier 5 BHK duplex penthouse overlooking Delhi Golf Club with private rooftop pool and elevator.'),

(4, 'The Sovereign Estate Floor', 'the-sovereign-estate-floor-chanakyapuri', 'Luxury Builder Floor', 'rent', 1200000.00, '₹12 Lakh / month', '5,500 Sq. Ft.', '800 Sq. Yds.', 4, 4, 3, 'Second Floor', 'Malcha Marg, Chanakyapuri, New Delhi', 'https://maps.google.com/?q=Malcha+Marg+Chanakyapuri+New+Delhi',
'A grand residence in Delhi\'s diplomatic quarter, ideal for ambassadors, corporate leaders, and multinational executives. Spanning an entire second floor of a newly constructed freehold building, the home provides exceptional security, acoustic insulation, spacious bedrooms with ensuite dressing rooms, and refined Italian marble finishing throughout.',
'/assets/images/properties/floor-chanakyapuri.jpg', 1, 'published', 4,
'Luxury Diplomatic Residence for Rent in Chanakyapuri | Elite Homez',
'Prestigious 4 BHK floor for lease in Chanakyapuri diplomatic enclave with top-tier security and Italian finishes.'),

(5, 'The Corner Manor at Panchsheel', 'the-corner-manor-panchsheel-park', 'Park-Facing Builder Floor', 'sale', 195000000.00, '₹19.50 Cr', '4,800 Sq. Ft.', '500 Sq. Yds.', 4, 5, 3, 'First Floor', 'Block N, Panchsheel Park North, New Delhi', 'https://maps.google.com/?q=Panchsheel+Park+North+New+Delhi',
'Commanding an enviable two-side open corner plot facing a lush community park, this newly completed builder floor offers unmatched natural cross-ventilation and sunlight. Includes a sprawling 45-foot living balcony, VRV air conditioning, automated ambient lighting scenes, and generous master suites with walk-in wardrobes.',
'/assets/images/properties/manor-panchsheel.jpg', 1, 'published', 5,
'Park-Facing 4 BHK Floor in Panchsheel Park | Elite Homez',
'Prime corner 4 BHK luxury floor facing central park in Panchsheel Park North, New Delhi.'),

(6, 'The Orchard Residence', 'the-orchard-residence-shanti-niketan', 'Standalone Luxury House', 'sale', 340000000.00, '₹34.00 Cr', '8,200 Sq. Ft.', '700 Sq. Yds.', 5, 6, 4, 'Ground + First + Second Floors', 'Shanti Niketan, New Delhi', 'https://maps.google.com/?q=Shanti+Niketan+New+Delhi',
'Situated in quiet, wide-road Shanti Niketan, this bespoke family manor represents the height of understated luxury. Highlights include a tranquil central courtyard with water features, private elevator, staff quarters for three, rooftop entertainment pavilion, and a 4-car stilt garage.',
'/assets/images/properties/residence-shanti-niketan.jpg', 1, 'published', 6,
'Bespoke Luxury Residence in Shanti Niketan | Elite Homez',
'5 BHK standalone luxury estate on 700 sq. yds. in Shanti Niketan with courtyard and private lift.');

-- 6. Property Features Mapping
-- Property 1 (Vasant Vihar Villa)
INSERT INTO property_features (property_id, feature_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10),
(1, 11), (1, 12), (1, 13), (1, 16), (1, 17), (1, 21), (1, 26), (1, 32), (1, 37), (1, 38);

-- Property 2 (Jor Bagh Residence)
INSERT INTO property_features (property_id, feature_id) VALUES
(2, 2), (2, 4), (2, 5), (2, 6), (2, 7), (2, 8), (2, 10), (2, 11), (2, 12), (2, 16),
(2, 17), (2, 21), (2, 26), (2, 27), (2, 28), (2, 36), (2, 38), (2, 39);

-- Property 3 (Golf Links Penthouse)
INSERT INTO property_features (property_id, feature_id) VALUES
(3, 1), (3, 3), (3, 4), (3, 5), (3, 6), (3, 7), (3, 8), (3, 11), (3, 12), (3, 16),
(3, 17), (3, 19), (3, 21), (3, 26), (3, 27), (3, 29), (3, 37), (3, 38), (3, 40);

-- Property 4 (Chanakyapuri Floor)
INSERT INTO property_features (property_id, feature_id) VALUES
(4, 4), (4, 5), (4, 6), (4, 7), (4, 8), (4, 11), (4, 12), (4, 16), (4, 17), (4, 21),
(4, 26), (4, 27), (4, 30), (4, 38), (4, 39), (4, 42);

-- Property 5 (Panchsheel Manor)
INSERT INTO property_features (property_id, feature_id) VALUES
(5, 4), (5, 5), (5, 6), (5, 7), (5, 8), (5, 11), (5, 12), (5, 16), (5, 17), (5, 21),
(5, 26), (5, 27), (5, 28), (5, 30), (5, 38), (5, 41);

-- Property 6 (Shanti Niketan Residence)
INSERT INTO property_features (property_id, feature_id) VALUES
(6, 2), (6, 3), (6, 4), (6, 5), (6, 6), (6, 7), (6, 8), (6, 11), (6, 12), (6, 13),
(6, 16), (6, 17), (6, 21), (6, 26), (6, 30), (6, 37), (6, 38), (6, 44);

-- 7. Real / Genuine Style Client Testimonials
INSERT INTO testimonials (client_name, designation, testimonial, rating, status, sort_order) VALUES
('Vikramaditya Singhal', 'Managing Partner, Singhal Capital Partners', 'Elite Homez facilitated our acquisition in Vasant Vihar with extraordinary discretion and market depth. Their guidance on municipal title verification and micro-market pricing was invaluable. They operate as true advisors, not transactional brokers.', 5, 1, 1),
('Ambassador H.E. Marcus Lindqvist', 'Diplomatic Mission', 'Securing an appropriate residence in Chanakyapuri requires precise knowledge of security parameters and diplomatic requirements. The team at Elite Homez understood our specifications immediately and delivered an exceptional estate seamlessly.', 5, 1, 2),
('Radhika & Sanjeev Kapoor', 'Enterprise Founder & Angel Investor', 'When looking for a park-facing property in Jor Bagh, patience and off-market relationships are essential. Elite Homez presented us with a discreet, unadvertised opportunity that matched our aesthetic expectations perfectly.', 5, 1, 3);

-- 8. Global Brand & Contact Settings
INSERT INTO settings (setting_key, setting_value, setting_group) VALUES
('site_name', 'Elite Homez', 'general'),
('site_tagline', 'your trust, our responsibility.', 'general'),
('phone_primary', '+91 98110 00000', 'contact'),
('phone_secondary', '+91 11 4100 0000', 'contact'),
('whatsapp_number', '+919811000000', 'contact'),
('whatsapp_display', '+91 98110 00000', 'contact'),
('email_primary', 'advisory@elitehomez.com', 'contact'),
('office_address', 'Level 4, Diplomatic Commercial Complex, Malcha Marg, Chanakyapuri, New Delhi 110021', 'contact'),
('google_maps_url', 'https://maps.google.com/?q=Chanakyapuri+New+Delhi', 'contact'),
('footer_brand_text', 'Elite Homez is a bespoke real estate advisory firm specializing in prime residential acquisitions, confidential divestments, and generational estates across the capital\'s most distinguished enclaves. With over two decades of trusted advisory, we deliver discreet, bespoke property solutions.', 'footer'),
('default_seo_title', 'Elite Homez | Premium Luxury Real Estate Advisory Delhi', 'seo'),
('default_meta_description', 'Elite Homez specializes in prime luxury residential properties, independent villas, builder floors, and estates in Vasant Vihar, Jor Bagh, Golf Links, and Chanakyapuri.', 'seo'),
('experience_years', '20+', 'company');
