$(document).ready(function() {
    var provinceSelect = $('#provinceSelect');
    var citySelect = $('#citySelect');
    var brgySelect = $('#brgySelect');
    
    // Define cities/municipalities for all provinces
    var citiesByProvince = {
        'Manila': ["Binondo", "Ermita", "Intramuros", "Malate", "Paco", "Pandacan", "Port Area", "Quiapo", "Sampaloc", "San Andres", "San Miguel", "San Nicolas", "Santa Ana", "Santa Cruz", "Santa Mesa", "Tondo", "Tutuban"],
        'Quezon City': ["Alicia", "Amihan", "Aurora", "Bagong Bayan", "Bagong Lipunan", "Bagong Pag-asa", "Bagong Silangan", "Bagumbayan", "Bahay Toro", "Balingasa", "Balintawak", "Batasan Hills", "Bayanihan", "Blue Ridge", "Botocan", "Bungad", "Capri", "Central", "Claro", "Commonwealth", "Cubao", "Culiat", "Damar", "Damar, Upper", "Damayan", "Damayan Lagi", "Del Monte", "Diliman", "Duyan-Duyan", "E Rodriguez", "Escopa", "Fairview", "Galas", "Horseshoe", "Immaculate Concepcion", "Industrial Valley", "Kaingin", "Kalusugan", "Kamuning", "Kanluran", "Krus Na Ligas", "Laging Handa", "Libis", "Lourdes", "Malo", "Manresa", "Mariana", "Mariblo", "Masagana", "Matalahib", "Matandang Balara", "Milagrosa", "Nagkaisang Nayon", "Nayong Kanluran", "New Era", "Novaliches Proper", "Obogon", "Old Capitol Site", "Paang Bundok", "Pag-ibig", "Paligsahan", "Paltok", "Pansol", "Pasong Putik", "Payatas", "Phil-Am", "Philippine Heart Center", "Pinagkaisahan", "Pinagong Parang", "Pinyahan", "Project 1", "Project 2", "Project 3", "Project 4", "Project 5", "Quirino District", "Ramon Magsaysay", "Roxas District", "Sacro Cuore", "Saint Ignatius", "Saint Martin de Porres", "Saint Peter", "Salvacion", "San Agustin", "San Antonio", "San Bartolome", "San Francisco del Monte", "San Isidro", "San Isidro Labrador", "San Jose", "San Juan", "San Roque", "San Vicente", "Santo Cristo", "Santo Niño", "Santo Rosario", "Santol", "Sauyo", "Silangan", "Sikatuna Village", "Socorro", "Sikatuna Village", "South Triangle", "Tagumpay", "Teachers Village", "Unang Sigaw", "UP Campus", "U.P. Village", "Ugong Norte", "Unang Pagkakaisa", "University of the Philippines", "Valencia", "Vasra", "Veterans Village", "Villa Maria Clara", "Wawang Pulo", "White Plains"],
        'Caloocan': ["Amparo", "Bagong Barrio", "Bagong Bayan", "Bagong Silang", "Bagumbong", "Baesa", "Bagong Silang", "Balintawak", "Barrio San Jose", "Barrio San Roque", "Camarin", "Congress Village", "Deparo", "Grace Park", "Heroes del 96", "Karuhatan", "Llano", "Mabini-J. P. Rizal", "Malaria", "Maypajo", "Morning Breeze", "Pangarap Village", "Paso de Blas", "Samson Road", "Sangandaan", "Santa Quiteria", "University Hills", "Victory Heights", "Zabarte Subdivision"],
        'Makati': ["Bangkal", "Bel-Air", "Carmona", "Cembo", "Comembo", "Dasmarinas", "East Rembo", "Forbes Park", "Guadalupe Nuevo", "Guadalupe Viejo", "Kasilawan", "La Paz", "Magallanes", "Olympia", "Palanan", "Pembo", "Pinagkaisahan", "Pio del Pilar", "Pitogo", "Poblacion", "Post Proper Northside", "Post Proper Southside", "Rizal", "San Antonio", "San Isidro", "San Lorenzo", "Santa Cruz", "Singkamas", "South Cembo", "Tejeros", "Urdaneta", "Valenzuela"],
        'Taguig': ["Bagumbayan", "Bagong Tanyag", "Bagumbayan", "Bambang", "Calzada", "Central Bicutan", "Central Signal Village", "Fort Bonifacio", "Hagonoy", "Ibayo-Tipas", "Kalawaan", "Ligid-Tipas", "Lower Bicutan", "Maharlika Village", "Napindan", "New Lower Bicutan", "North Daang Hari", "North Signal Village", "Palingon", "Sampaloc", "Santa Ana", "Tuktukan", "Upper Bicutan", "Ususan", "Wawa"],

        'Baguio': ["Baguio City"],
        'Benguet': ["La Trinidad", "Itogon", "Tuba", "Tublay"],
        'Kalinga': ["Tabuk", "Balbalan", "Pinukpuk", "Rizal"],
        'Apayao': ["Kabugao", "Luna", "Conner", "Pudtol", "Flora", "Santa Marcela"],
        'Ifugao': ["Lagawe", "Kiangan", "Lamut", "Hingyon", "Tinoc", "Banaue"],
    
        'Ilocos Norte': ["Laoag", "Batac", "Dingras", "Paoay", "San Nicolas", "Sarrat"],
        'Ilocos Sur': ["Vigan", "Candon", "Bantay", "Narvacan", "Caoayan", "Santa Catalina"],
        'La Union': ["San Fernando", "Agoo", "Aringay", "Bauang", "Caba", "Santo Tomas"],
        'Pangasinan': ["Lingayen", "Dagupan", "Urdaneta", "San Carlos", "Mangaldan", "Tayug"],

        'Cagayan': ["Tuguegarao", "Aparri", "Lal-Lo", "Gattaran", "Solana", "Enrile"],
        'Isabela': ["Ilagan", "Cauayan", "Santiago", "Alicia", "Roxas", "Cauayan"],
        'Nueva Vizcaya': ["Bayombong", "Solano", "Aritao", "Dupax del Sur", "Ambaguio", "Kasibu"],
        'Quirino': ["Cabarroguis", "Diffun", "Aglipay", "Nagtipunan", "Maddela", "Saguday"],
    
        'Aurora': ["Baler", "Casiguran", "Dilasag", "Dinalungan", "Dingalan", "Dipaculao"],
        'Bataan': ["Balanga", "Dinalupihan", "Hermosa", "Limay", "Mariveles", "Morong"],
        'Bulacan': ["Malolos", "San Jose del Monte", "Meycauayan", "Marilao", "Baliuag", "Santa Maria"],
        'Nueva Ecija': ["Cabanatuan", "San Jose City", "Gapan", "Munoz", "Palayan", "Talavera"],
        'Pampanga': ["San Fernando", "Angeles", "Mabalacat", "Porac", "Arayat", "Candaba"],
        'Tarlac': ["Tarlac City", "Paniqui", "Concepcion", "Capas", "Camiling", "Tarlac"],
        'Zambales': ["Olongapo", "Subic", "Iba", "Botolan", "Masinloc", "Castillejos"],

        'Marinduque': ["Boac", "Gasan", "Mogpog", "Sta. Cruz", "Torrijos"],
        'Occidental Mindoro': ["Mamburao", "Abra de Ilog", "Calintaan", "Looc", "Lubang", "Magsaysay", "Paluan", "Rizal", "Sablayan", "San Jose"],
        'Oriental Mindoro': ["Calapan", "Baco", "Bansud", "Bongabong", "Bulalacao", "Gloria", "Mansalay", "Naujan", "Pinamalayan", "Pola", "Puerto Galera", "Roxas", "San Teodoro", "Socorro", "Victoria"],
        'Palawan': ["Puerto Princesa", "Aborlan", "Agutaya", "Araceli", "Balabac", "Bataraza", "Brooke's Point", "Busuanga", "Cagayancillo", "Coron", "Culion", "Cuyo", "Dumaran", "El Nido", "Kalayaan", "Linapacan", "Magsaysay", "Narra", "Quezon", "Rizal", "Roxas", "San Vicente", "Sofronio Española"],
        'Romblon': ["Romblon", "Cajidiocan", "Calatrava", "Concepcion", "Corcuera", "Ferrol", "Looc", "Magdiwang", "Odiongan", "Romblon", "San Agustin", "San Andres", "San Fernando", "San Jose", "Santa Fe", "Santa Maria"],

        'Albay': ["Legazpi City", "Ligao City", "Tabaco City", "Bacacay", "Camalig", "Daraga", "Guinobatan", "Jovellar", "Libon", "Malilipot", "Malinao", "Manito", "Oas", "Pio Duran", "Polangui", "Rapu-Rapu", "Santo Domingo", "Tiwi"],
        'Camarines Norte': ["Daet", "Basud", "Capalonga", "Jose Panganiban", "Labo", "Mercedes", "Paracale", "San Lorenzo Ruiz", "San Vicente", "Santa Elena", "Talisay", "Vinzons"],
        'Camarines Sur': ["Iriga City", "Naga City", "Baao", "Balatan", "Bato", "Bombon", "Buhi", "Bula", "Cabusao", "Calabanga", "Camaligan", "Canaman", "Caramoan", "Del Gallego", "Gainza", "Garchitorena", "Goa", "Lagonoy", "Libmanan", "Lupi", "Magarao", "Milaor", "Minalabac", "Nabua", "Ocampo", "Pamplona", "Pasacao", "Pili", "Presentacion", "Ragay", "Sagnay", "San Fernando", "San Jose", "Sipocot", "Siruma", "Tigaon", "Tinambac"],
        'Catanduanes': ["Virac", "Bagamanoc", "Baras", "Bato", "Caramoran", "Gigmoto", "Pandan", "Panganiban", "San Andres", "San Miguel", "Viga", "Viga", "Viga"],
        'Masbate': ["Masbate City", "Aroroy", "Baleno", "Balud", "Batuan", "Cataingan", "Cawayan", "Claveria", "Dimasalang", "Esperanza", "Mandaon", "Milagros", "Mobo", "Monreal", "Palanas", "Pio V. Corpuz", "Placer", "San Fernando", "San Jacinto", "San Pascual", "Uson"],
        'Sorsogon': ["Sorsogon City", "Barcelona", "Bulan", "Bulusan", "Casiguran", "Castilla", "Donsol", "Gubat", "Irosin", "Juban", "Magallanes", "Matnog", "Pilar", "Prieto Diaz", "Santa Magdalena"],

        'Aklan': ["Balete", "Banga", "Batan", "Buruanga", "Ibajay", "Kalibo", "Lezo", "Libacao", "Madalag", "Makato", "Malay", "Malinao", "Nabas", "New Washington", "Numancia", "Tangalan"],
        'Antique': ["Anini-y", "Barbaza", "Belison", "Bugasong", "Caluya", "Culasi", "Hamtic", "Laua-an", "Libertad", "Pandan", "Patnongon", "San Jose de Buenavista", "San Remigio", "Sebaste", "Sibalom", "Tibiao", "Tobias Fornier", "Valderrama"],
        'Capiz': ["Cuartero", "Dao", "Dumalag", "Dumarao", "Ivisan", "Jamindan", "Maayon", "Mambusao", "Panay", "Panitan", "Pilar", "Pontevedra", "President Roxas", "Roxas City", "Sapi-an", "Sigma", "Tapaz"],
        'Guimaras': ["Buenavista", "Jordan", "Nueva Valencia", "San Lorenzo", "Sibunag"],
        'Iloilo': ["Ajuy", "Alimodian", "Anilao", "Badiangan", "Balasan", "Banate", "Barotac Nuevo", "Barotac Viejo", "Batad", "Bingawan", "Cabatuan", "Calinog", "Carles", "Concepcion", "Dingle", "Dueñas", "Dumangas", "Estancia", "Guimbal", "Igbaras", "Iloilo City", "Januiay", "Lambunao", "Leganes", "Lemery", "Leon", "Maasin", "Miagao", "Mina", "New Lucena", "Oton", "Passi City", "Pavia", "Pototan", "San Dionisio", "San Enrique", "San Joaquin", "San Miguel", "Santa Barbara", "Sara", "Tigbauan", "Tubungan", "Zarraga"],
        'Neg. Occ': ["Bacolod City", "Bago City", "Binalbagan", "Calatrava", "Candoni", "Cauayan", "Enrique B. Magalona", "Escalante City", "Himamaylan City", "Hinigaran", "Hinoba-an", "Ilog", "Isabela", "Kabankalan City", "La Carlota City", "La Castellana", "Manapla", "Moises Padilla", "Murcia", "Pontevedra", "Pulupandan", "Sagay City", "Salvador Benedicto", "San Carlos City", "San Enrique", "Silay City", "Sipalay City", "Talisay City", "Toboso", "Valladolid", "Victorias City"],

        'Bohol': ["Alburquerque", "Alicia", "Anda", "Antequera", "Baclayon", "Balilihan", "Batuan", "Bien Unido", "Bilar", "Buenavista", "Calape", "Candijay", "Carmen", "Catigbian", "Clarin", "Corella", "Cortes", "Dagohoy", "Danao", "Dauis", "Dimiao", "Duero", "Garcia Hernandez", "Getafe", "Guindulman", "Inabanga", "Jagna", "Lila", "Loay", "Loboc", "Loon", "Mabini", "Maribojoc", "Panglao", "Pilar", "Pres. Carlos P. Garcia", "Sagbayan", "San Isidro", "San Miguel", "Sevilla", "Sierra Bullones", "Sikatuna", "Tagbilaran City", "Talibon", "Trinidad", "Tubigon", "Ubay", "Valencia"],
        'Cebu': ["Alcantara", "Alcoy", "Alegria", "Aloguinsan", "Argao", "Asturias", "Badian", "Balamban", "Bantayan", "Barili", "Bogo City", "Boljoon", "Borbon", "Carcar City", "Carmen", "Catmon", "Cebu City", "Compostela", "Consolacion", "Cordova", "Daanbantayan", "Dalaguete", "Danao City", "Dumanjug", "Ginatilan", "Lapu-Lapu City", "Liloan", "Madridejos", "Malabuyoc", "Mandaue City", "Medellin", "Minglanilla", "Moalboal", "Naga City", "Oslob", "Pilar", "Pinamungajan", "Poro", "Ronda", "Samboan", "San Fernando", "San Francisco", "San Remigio", "Santa Fe", "Santander", "Sibonga", "Sogod", "Tabogon", "Tabuelan", "Talisay City", "Toledo City", "Tuburan", "Tudela"],
        'Neg. Or.': ["Amlan", "Ayungon", "Bacong", "Bais City", "Basay", "Bindoy", "Canlaon City", "Dauin", "Dumaguete City", "Guihulngan City", "Jimalalud", "La Libertad", "Mabinay", "Manjuyod", "Pamplona", "San Jose", "Santa Catalina", "Siaton", "Sibulan", "Tanjay City", "Tayasan", "Valencia", "Vallehermoso", "Zamboanguita"],
        'Siquijor': ["Enrique Villanueva", "Larena", "Lazi", "Maria", "San Juan", "Siquijor"],

        'Biliran': ["Almeria", "Biliran", "Cabucgayan", "Caibiran", "Culaba", "Kawayan", "Maripipi", "Naval"],
        'Eastern Samar': ["Arteche", "Balangiga", "Balangkayan", "Borongan", "Can-avid", "Dolores", "General MacArthur", "Giporlos", "Guiuan", "Hernani", "Jipapad", "Lawaan", "Llorente", "Maslog", "Maydolong", "Mercedes", "Oras", "Quinapondan", "Salcedo", "San Julian", "San Policarpo", "Sulat", "Taft"],
        'Leyte': ["Abuyog", "Alangalang", "Albuera", "Babatngon", "Barugo", "Bato", "Burauen", "Calubian", "Capoocan", "Carigara", "Dagami", "Dulag", "Hilongos", "Hindang", "Inopacan", "Isabel", "Jaro", "Javier", "Julita", "Kananga", "La Paz", "Leyte", "MacArthur", "Mahaplag", "Matag-ob", "Matalom", "Mayorga", "Merida", "Ormoc City", "Palo", "Palompon", "Pastrana", "San Isidro", "San Miguel", "Santa Fe", "Tabango", "Tabontabon", "Tacloban City", "Tanauan", "Tolosa", "Tunga", "Villaba"],
        'Northern Samar': ["Allen", "Biri", "Bobon", "Capul", "Catarman", "Catubig", "Gamay", "Laoang", "Lapinig", "Las Navas", "Lavezares", "Lope de Vega", "Mapanas", "Mondragon", "Palapag", "Pambujan", "Rosario", "San Antonio", "San Isidro", "San Jose", "San Roque", "San Vicente", "Silvino Lobos", "Victoria"],
        'Samar': ["Almagro", "Basey", "Calbayog City", "Calbiga", "Catbalogan City", "Daram", "Gandara", "Hinabangan", "Jiabong", "Marabut", "Matuguinao", "Motiong", "Pagsanghan", "Paranas", "Pinabacdao", "San Jorge", "San Jose de Buan", "San Sebastian", "Santa Margarita", "Santa Rita", "Santo Niño", "Tagapul-an", "Talalora", "Tarangnan", "Villareal", "Zumarraga"],
        'Southern Leyte': ["Anahawan", "Bontoc", "Hinunangan", "Hinundayan", "Libagon", "Liloan", "Limasawa", "Maasin City", "Macrohon", "Malitbog", "Padre Burgos", "Pintuyan", "Saint Bernard", "San Francisco", "San Juan", "San Ricardo", "Silago", "Sogod"],

        'Zamboanga City': ["Ayer", "Baluno", "Boalan", "Bolong", "Cabaluay", "Calaanan", "Camino Nuevo", "Campo Islam", "Canelar", "Cawit", "Dita", "Divisoria", "Guiwan", "Kasanyangan", "La Paz", "Labuan", "Lamisahan", "Landang Gua", "Landang Laum", "Lanzones", "Licomo", "Limaong", "Limpapa", "Mampang", "Manalipa", "Manicahan", "Mariki", "Mercedes", "Pamucutan", "Panubigan", "Pasilmanta", "Pasonanca", "Putik", "Quiniput", "Recodo", "Rio Hondo", "San Jose Cawa-Cawa", "San Jose Gusu", "San Roque", "San Roque", "Sangali", "Santa Barbara", "Santa Catalina", "Santa Maria", "Santo Niño", "Santo Rosario", "Sinubong", "Tagasilay", "Talisayan", "Talon-Talon", "Taluksangay", "Tetuan", "Tictapul", "Tugbungan", "Tumaga", "Tumalutab", "Vitali", "Zambowood"],
        'Zamboanga del Norte': ["Baliguian", "Godod", "Gutalac", "Jose Dalman", "Kalawit", "Katipunan", "La Libertad", "Labason", "Leon B. Postigo", "Liloy", "Manukan", "Mutia", "Pinan", "Polanco", "President Manuel A. Roxas", "Rizal", "Salug", "Sergio Osmeña Sr.", "Siayan", "Sibuco", "Sibutad", "Sindangan", "Siocon", "Sirawai", "Tampilisan"],
        'Zamboanga del Sur': ["Aurora", "Bayog", "Dimataling", "Dinas", "Dumalinao", "Dumingag", "Guipos", "Josefina", "Kumalarang", "Labangan", "Lakewood", "Lapuyan", "Mahayag", "Margosatubig", "Midsalip", "Molave", "Pagadian City", "Pitogo", "Ramon Magsaysay", "San Miguel", "San Pablo", "Sominot", "Tabina", "Tambulig", "Tigbao", "Tukuran", "Vincenzo A. Sagun"],
        'Zamboanga Sibugay': ["Alicia", "Buug", "Diplahan", "Imelda", "Ipil", "Kabasalan", "Mabuhay", "Malangas", "Naga", "Olutanga", "Payao", "Roseller Lim", "Siay", "Talusan", "Titay", "Tungawan"],

        'Bukidnon': ["Baungon", "Cabanglasan", "Damulog", "Dangcagan", "Don Carlos", "Impasug-ong", "Kadingilan", "Kalilangan", "Kibawe", "Kitaotao", "Lantapan", "Libona", "Malaybalay City", "Manolo Fortich", "Maramag", "Pangantucan", "Quezon", "San Fernando", "Sumilao", "Talakag", "Valencia City"],
        'Camiguin': ["Catarman", "Guinsiliban", "Mahinog", "Mambajao", "Sagay"],
        'Lanao del Norte': ["Bacolod", "Baloi", "Baroy", "Iligan City", "Kapatagan", "Kauswagan", "Kolambugan", "Lala", "Linamon", "Magsaysay", "Maigo", "Matungao", "Munai", "Nunungan", "Pantao Ragat", "Pantar", "Poona Piagapo", "Salvador", "Sapad", "Sultan Naga Dimaporo", "Tagoloan", "Tangcal", "Tubod"],
        'Misamis Occidental': ["Aloran", "Baliangao", "Ballesteros", "Bonifacio", "Calamba", "Concepcion", "Jimenez", "Lopez Jaena", "Oroquieta City", "Ozamiz City", "Panaon", "Plaridel", "Sapang Dalaga", "Sinacaban", "Tangub City", "Tudela"],
        'Misamis Oriental': ["Alubijid", "Balingasag", "Balingoan", "Binuangan", "Cagayan de Oro City", "Claveria", "El Salvador City", "Gingoog City", "Gitagum", "Initao", "Jasaan", "Kinoguitan", "Lagonglong", "Laguindingan", "Libertad", "Lugait", "Magsaysay", "Manticao", "Medina", "Naawan", "Opol", "Salay", "Sugbongcogon", "Tagoloan", "Talisayan", "Villanueva"],

        'Compostela Valley': ["Compostela", "Laak", "Mabini", "Maco", "Maragusan", "Mawab", "Monkayo", "Montevista", "Nabunturan", "New Bataan", "Pantukan"],
        'Davao del Norte': ["Asuncion", "Braulio E. Dujali", "Carmen", "Kapalong", "New Corella", "Panabo City", "Samal City", "San Isidro", "Santo Tomas", "Tagum City", "Talaingod"],
        'Davao del Sur': ["Bansalan", "Davao City", "Digos City", "Hagonoy", "Kiblawan", "Magsaysay", "Malalag", "Matanao", "Padada", "Santa Cruz", "Santa Maria", "Sulop"],
        'Davao Occidental': ["Don Marcelino", "Jose Abad Santos", "Malita", "Santa Maria", "Sarangani"],
        'Davao Oriental': ["Baganga", "Banaybanay", "Boston", "Caraga", "Cateel", "Governor Generoso", "Lupon", "Manay", "Mati City", "San Isidro", "Tarragona"],

        'Cotabato': ["Alamada", "Aleosan", "Antipas", "Arakan", "Banisilan", "Carmen", "Kabacan", "Libungan", "M'lang", "Magpet", "Makilala", "Matalam", "Midsayap", "Pigcawayan", "Pikit", "President Roxas", "Tulunan"],
        'Sarangani': ["Alabel", "Glan", "Kiamba", "Maasim", "Maitum", "Malapatan"],
        'South Cotabato': ["Banga", "General Santos City", "Koronadal City", "Lake Sebu", "Norala", "Polomolok", "Santo Niño", "Surallah", "T'boli", "Tampakan", "Tantangan", "Tupi"],
        'Sultan Kudarat': ["Bagumbayan", "Columbio", "Esperanza", "Isulan", "Kalamansig", "Lambayong", "Lebak", "Lutayan", "Palimbang", "President Quirino"],

        'Agusan del Norte': ["Buenavista", "Cabadbaran", "Carmen", "Jabonga", "Kitcharao", "Las Nieves", "Magallanes", "Nasipit", "Remedios T. Romualdez", "Santiago", "Tubay"],
        'Agusan del Sur': ["Bayugan", "Bunawan", "Esperanza", "La Paz", "Loreto", "Prosperidad", "Rosario", "San Francisco", "San Luis", "Santa Josefa", "Sibagat", "Talacogon", "Trento", "Veruela"],
        'Dinagat Islands': ["Basilisa", "Cagdianao", "Dinagat", "Loreto", "San Jose", "Tubajon"],
        'Surigao del Norte': ["Alegria", "Bacuag", "Burgos", "Claver", "Dapa", "Del Carmen", "General Luna", "Gigaquit", "Mainit", "Malimono", "Pilar", "Placer", "San Benito", "San Francisco", "San Isidro", "Santa Monica", "Sison", "Socorro", "Surigao City", "Tagana-an", "Tubod"],
        'Surigao del Sur': ["Barobo", "Bayabas", "Bislig", "Cagwait", "Cantilan", "Carmen", "Carrascal", "Cortes", "Hinatuan", "Lanuza", "Lianga", "Lingig", "Madrid", "Marihatag", "San Agustin", "San Miguel", "Tagbina", "Tago", "Tandag"],

        'Basilan': ["Akbar", "Al-Barka", "Hadhji Mohammad Ajul", "Hadji Muhtamad", "Isabela City", "Lamitan", "Lantawan", "Maluso", "Sumisip", "Tabuan-Lasa", "Tipo-Tipo", "Tuburan", "Ungkaya Pukan"],
        'Lanao del Sur': ["Bacolod-Kalawi", "Balabagan", "Balindong", "Bayang", "Binidayan", "Buadiposo-Buntong", "Bubong", "Butig", "Calanogas", "Ditsaan-Ramain", "Ganassi", "Kapai", "Kapatagan", "Lumbaca-Unayan", "Lumbatan", "Lumbayanague", "Madalum", "Madamba", "Maguing", "Malabang", "Marantao", "Marogong", "Masiu", "Mulondo", "Pagayawan", "Piagapo", "Poona Bayabao", "Pualas", "Saguiaran", "Sultan Dumalondong", "Picong", "Tagoloan", "Tamparan", "Taraka", "Tubaran", "Tugaya", "Wao"],
        'Maguindanao': ["Ampatuan", "Barira", "Buldon", "Datu Abdullah Sangki", "Datu Anggal Midtimbang", "Datu Blah T. Sinsuat", "Datu Hoffer Ampatuan", "Datu Montawal", "Datu Odin Sinsuat", "Datu Paglas", "Datu Piang", "Datu Salibo", "Datu Saudi-Ampatuan", "Datu Unsay", "General Salipada K. Pendatun", "Guindulungan", "Kabuntalan", "Mamasapano", "Mangudadatu", "Pagagawan", "Pagalungan", "Paglat", "Pandag", "Pikit", "Rajah Buayan", "Shariff Aguak", "Shariff Saydona Mustapha", "South Upi", "Sultan Kudarat", "Sultan Mastura", "Sultan Sa Barongis", "Sultan Sumagka", "Talayan", "Talitay", "Upi"],
        'Sulu': ["Hadji Panglima Tahil", "Indanan", "Jolo", "Kalingalan Caluang", "Lugus", "Luuk", "Maimbung", "Old Panamao", "Omar", "Pandami", "Panglima Estino", "Pangutaran", "Parang", "Pata", "Patikul", "Siasi", "Talipao", "Tapul", "Tongkil"],
        'Tawi-Tawi': ["Bongao", "Languyan", "Mapun", "Panglima Sugala", "Sapa-Sapa", "Sibutu", "Simunul", "Sitangkai", "South Ubian", "Tandubas", "Turtle Islands"],
        
    };

    // Handle region selection
    $('#regionSelect').on('change', function() {
        var selectedRegion = $(this).val();
        provinceSelect.empty();
        citySelect.empty();
        brgySelect.empty();

        if (selectedRegion === 'NCR') {
            // Provinces in NCR
            var ncrProvinces = ["Manila", "Quezon City", "Caloocan", "Makati", "Taguig"];
            provinceSelect.append('<option value="">Select Province</option>');
            populateOptions(provinceSelect, ncrProvinces);
        } else if (selectedRegion === 'CAR') {
            // Provinces in CAR
            var carProvinces = ["Baguio", "Benguet", "Kalinga", "Apayao", "Ifugao"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < carProvinces.length; i++) {
                provinceSelect.append('<option value="' + carProvinces[i] + '">' + carProvinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region1') {
            // Provinces in Region I
            var region1Provinces = ["Ilocos Norte", "Ilocos Sur", "La Union", "Pangasinan"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region1Provinces.length; i++) {
                provinceSelect.append('<option value="' + region1Provinces[i] + '">' + region1Provinces[i] + '</option>');
            }
        }else if (selectedRegion === 'Region2') {
            // Provinces in Region II
            var region2Provinces = ["Cagayan", "Isabela", "Nueva Vizcaya", "Quirino"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region2Provinces.length; i++) {
                provinceSelect.append('<option value="' + region2Provinces[i] + '">' + region2Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region3') {
            // Provinces in Region III
            var region3Provinces = ["Aurora", "Bataan", "Bulacan", "Nueva Ecija", "Pampanga", "Tarlac", "Zambales"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region3Provinces.length; i++) {
                provinceSelect.append('<option value="' + region3Provinces[i] + '">' + region3Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region4A') {
            // Provinces in Region IV-A
            var region4AProvinces = ["Aurora", "Batangas", "Cavite", "Laguna", "Quezon", "Rizal"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region4AProvinces.length; i++) {
                provinceSelect.append('<option value="' + region4AProvinces[i] + '">' + region4AProvinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region4B') {
            // Provinces in Region IV-B
            var region4BProvinces = ["Marinduque", "Occidental Mindoro", "Oriental Mindoro", "Palawan", "Romblon"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region4BProvinces.length; i++) {
                provinceSelect.append('<option value="' + region4BProvinces[i] + '">' + region4BProvinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region5') {
            // Provinces in Region V
            var region5Provinces = ["Albay", "Camarines Norte", "Camarines Sur", "Catanduanes", "Masbate", "Sorsogon"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region5Provinces.length; i++) {
                provinceSelect.append('<option value="' + region5Provinces[i] + '">' + region5Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region6') {
            // Provinces in Region VI
            var region6Provinces = ["Aklan", "Antique", "Capiz", "Guimaras", "Iloilo", "Neg. Occ"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region6Provinces.length; i++) {
                provinceSelect.append('<option value="' + region6Provinces[i] + '">' + region6Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region7') {
            // Provinces in Region VII
            var region7Provinces = ["Bohol", "Cebu", "Neg. Or.", "Siquijor"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region7Provinces.length; i++) {
                provinceSelect.append('<option value="' + region7Provinces[i] + '">' + region7Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region8') {
            // Provinces in Region VIII
            var region8Provinces = ["Biliran", "Eastern Samar", "Leyte", "Northern Samar", "Samar", "Southern Leyte"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region8Provinces.length; i++) {
                provinceSelect.append('<option value="' + region8Provinces[i] + '">' + region8Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region9') {
            // Provinces in Region IX
            var region9Provinces = ["Zamboanga City", "Zamboanga del Norte", "Zamboanga del Sur", "Zamboanga Sibugay"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region9Provinces.length; i++) {
                provinceSelect.append('<option value="' + region9Provinces[i] + '">' + region9Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region10') {
            // Provinces in Region X
            var region10Provinces = ["Bukidnon", "Camiguin", "Lanao del Norte", "Misamis Occidental", "Misamis Oriental"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region10Provinces.length; i++) {
                provinceSelect.append('<option value="' + region10Provinces[i] + '">' + region10Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region11') {
            // Provinces in Region XI
            var region11Provinces = ["Compostela Valley", "Davao del Norte", "Davao del Sur", "Davao Occidental", "Davao Oriental"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region11Provinces.length; i++) {
                provinceSelect.append('<option value="' + region11Provinces[i] + '">' + region11Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region12') {
            // Provinces in Region XII
            var region12Provinces = ["Cotabato", "Sarangani", "South Cotabato", "Sultan Kudarat"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region12Provinces.length; i++) {
                provinceSelect.append('<option value="' + region12Provinces[i] + '">' + region12Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'Region13') {
            // Provinces in Region XIII (Caraga)
            var region13Provinces = ["Agusan del Norte", "Agusan del Sur", "Dinagat Islands", "Surigao del Norte", "Surigao del Sur"];
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < region13Provinces.length; i++) {
                provinceSelect.append('<option value="' + region13Provinces[i] + '">' + region13Provinces[i] + '</option>');
            }
        } else if (selectedRegion === 'BARMM') {
            // Provinces in BARMM
            var barmmProvinces = ["Basilan", "Lanao del Sur", "Maguindanao", "Sulu", "Tawi-Tawi"];
            provinceSelect.append('<option value="">Select Province</option>');
            provinceSelect.append('<option value="">Select Province</option>');
            for (var i = 0; i < barmmProvinces.length; i++) {
                provinceSelect.append('<option value="' + barmmProvinces[i] + '">' + barmmProvinces[i] + '</option>');
            }
        }
        // Add similar blocks for other regions and provinces
        
        // Populate province and city options
        provinceSelect.on('change', function() {
            var selectedProvince = $(this).val();
            citySelect.empty();

            // Populate cities/municipalities based on the selected province
            if (selectedProvince in citiesByProvince) {
                var cities = citiesByProvince[selectedProvince];
                populateOptions(citySelect, cities);
            }
        });
    });
    
    // Function to populate select options
    function populateOptions(selectElement, options) {
        selectElement.empty();
        selectElement.append('<option value="">Select City/Municipality</option>');
        for (var i = 0; i < options.length; i++) {
            selectElement.append('<option value="' + options[i] + '">' + options[i] + '</option>');
        }
    }

    $('#citySelect').on('change', function() {
        var selectedCity = $(this).val();
        brgySelect.empty();
        if (selectedCity === 'Bacolod City') {
            var bacolodBrgy = [
                "Alangilan","Alijis","Banago","Barangay 1 (Poblacion)","Barangay 2 (Poblacion)","Barangay 3 (Poblacion)","Barangay 4 (Poblacion)","Barangay 5 (Poblacion)","Barangay 6 (Poblacion)","Barangay 7 (Poblacion)","Barangay 8 (Poblacion)","Barangay 9 (Poblacion)","Barangay 10 (Poblacion)","Barangay 11 (Poblacion)","Barangay 12 (Poblacion)","Barangay 13 (Poblacion)","Barangay 14 (Poblacion)","Barangay 15 (Poblacion)","Barangay 16 (Poblacion)","Barangay 17 (Poblacion)","Barangay 18 (Poblacion)","Barangay 19 (Poblacion)","Barangay 20 (Poblacion)","Barangay 21 (Poblacion)","Barangay 22 (Poblacion)","Barangay 23 (Poblacion)","Barangay 24 (Poblacion)","Barangay 25 (Poblacion)","Barangay 26 (Poblacion)","Barangay 27 (Poblacion)","Barangay 28 (Poblacion)","Barangay 29 (Poblacion)","Barangay 30 (Poblacion)","Barangay 31 (Poblacion)","Barangay 32 (Poblacion)","Barangay 33 (Poblacion)","Barangay 34 (Poblacion)","Barangay 35 (Poblacion)","Barangay 36 (Poblacion)","Barangay 37 (Poblacion)","Barangay 38 (Poblacion)","Barangay 39 (Poblacion)","Barangay 40 (Poblacion)"
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, bacolodBrgy);
        }

        if (selectedCity === 'Bago City') {
            var bagoBrgy = [
                "Ma-ao","Taloc","Hermelinda Homes","Poblacion","Bagroy","Tabunan","Balingasag","Nagasi","Ilijan","Don Jorge L. Araneta","Guinhalaran","Camingawan","Atipuluan","Himoga-an Baybay","Sampinit","Manalad","Caridad","Bago City Proper","Busay","Binubuhan","Bagacay","Cabilawan","Dumlog","Ilijan Norte","Nagasi Poblacion","Santa Monica","Balicotoc","Marilog","Malingin","Napnud","Cansauro","Tabunan Poblacion","Baliwagan","Kabulakan","Abuanan","Ilijan Sur","Padre Zamora","Odiong","Mailum","Agnaga","Malingin Poblacion","Kaitum","Pacol","Aningalan","Guadalupe","Cordova","Pacol Poblacion","Haguimit","Bagroy Poblacion","Cervantes","Camingawan Poblacion","Sampinit Poblacion","Calumangan","Baliwagan Poblacion","Caridad Poblacion"
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, bagoBrgy);
        }
        
        if (selectedCity === 'Binalbagan') {
            var binalbaganBrgy = [
                "1st Ward","2nd Ward","3rd Ward","4th Ward","5th Ward","6th Ward","7th Ward","8th Ward","9th Ward","10th Ward","11th Ward","12th Ward","Abdul","Agbay","Agdahon","Antipolo","Aureliana","Bagroy","Balalan","Balayong","Bantayan","Baylon","Bisitahan","Buenavista","Cabacungan","Camandag","Camansi","Carabalan","Carabalan (Pob.)","Carayrayan","Catabla","Cubay","Dancalan","Gawahon","Guinpanaan","Inolingan","Isabel","Katilingban","Lublub","Lumbia","Lunok","Magallon Cadre","Magallon Dalisay","Magallon Linusay","Malusgod","Nagasi","Nagasi Poblacion","Obrero","Paglaum","Pandan","Poblacion","San Rafael","San Antonio","San Isidro","San Juan","San Pedro","San Teodoro","Santa Clara","Santa Cruz","Tabu","Tagda","Tagukon","Taloc","Tan-awan","Tiglauan","Villanueva","Zamora",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, binalbaganBrgy);
        }
        
        if (selectedCity === 'Calatrava') {
            var calatravaBrgy = [
                "Balintawak","Cabunga-an","Caliling","Cambaye","Canlandog","Dalisay","Lanang","Magsaysay","Naguilayan","Old Sagay","Poblacion","Rizal","San Francisco","San Isidro","San Jose","San Juan","San Miguel","San Pedro","San Roque","San Vicente","Santa Catalina","Santo Niño","Tina-ogan","Villa Consorcia",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, calatravaBrgy);
        }

        if (selectedCity === 'Candoni') {
            var candoniBrgy = [
                "Bungahin","Cabarasan Daku","Cabarasan Guti","Calongonan","Caningay","Carmen","E. Lopue","F. Estanislao","Fabrica","La Purisima","M. Lopue","Magsaysay","Malingin","Manlucahoc","Mansalanao","Mapili","Nalundan","Nauhang","Pangatinan","Poblacion","San Juan","San Vicente","Santa Rosa","Saugan","Sebaste","Sibucao","Sikatuna","Talacdan","Tamlang","Tuyom",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, candoniBrgy);
        }
        
        if (selectedCity === 'Cauayan') {
            var cauayanBrgy = [
                "Aliling","Bagsakan","Baikingon","Baliw","Balocawe","Banga","Batuan","Cabadbaran","Cahayagan","Calaca-an","Caliling","Caymito","Cayog-oyog","Concepcion","Curva","Guinhulacan","Isio","Kabac","Kabahub","Kabuling","Kabulihan","Kabulihan Poblacion","Kaman-uhan","Kumaliskis","La Castellana","Laga-an","Langub","Libertad","Linaon","Mabinay","Mabini","Malalison","Mambalon","Man-uling","Maugma","Montilla","Narauis","Nasol","Napacao","Nauhang","Pagda-o","Pagsanjan","Pantao","Patabog","Poblacion","Salamanca","Salvador Benedicto","San Agustin","San Enrique","San Francisco","San Jose","San Miguel","Santa Cruz","Sibucao","Talisay","Tampalon","Tambojangin","Tan-agan","Tinongan","Tuyom","Ubos","Unabia","Villaflores","Villahermosa","Villalon","Villareal","Vista Alegre",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, cauayanBrgy);
        }
        
        if (selectedCity === 'Enrique B. Magalona') {
            var magalonaBrgy = [
                "Aurora","Babaylan","Bagumbayan","Banquerohan","Barcelona","Bilao","Binonga","Buenavista","Caduha-an","Cahilan 1","Cahilan 2","Cansilayan","Canroma","Concepcion","Doldol","Eduardo G. Magalona (Tambongan)","Efigenio Lizares","Fabrica","Gahit","Guimbalaon","Haguimit","Himoga-an Baybay","Himoga-an Daku","Hinigaran","Hinoban","Humayhumay","Igmaya-an","Jaguimitan","La Paz","Lacay Dol","Lacay Gua","Lacayon","Lonoy","Lopez Jaena","Mabini","Maga-ao","Magallon Cadre","Magallon Dalisay","Magallon Linusay","Ma-ao","Marcelo","Marcos","Minoyan","Montelibano","Nabitasan","Nalanda","Nagbalaye","Nagsaha","Nanga","Orong","Pacol","Palampas","Pandanon Silos","Pandanon Tampi","Pandanon-Banago","Patlad","Pinapugasan","Polo","Pook","Quipot","Quisao","Robles","San Isidro","San Jose","San Juan","San Miguel","San Nicolas","San Pedro","San Roque","Santa Ana","Santa Clara","Santa Elena","Santa Isabel","Santa Rosa","Santa Teresita","Santo Niño","Sibucao","Siquijor","Sitio Caboy","Sitio Cale","Sitio Canlusong","Sitio Catig","Sitio Manlantad","Sitio Mapait","Sitio Masaling","Sitio Nabor","Sitio Nagak","Sitio Nga-nga","Sitio Olampo","Sitio Palaka","Sitio Palermo","Sitio Pasco","Sitio Patag","Sitio Piso","Sitio Pula","Sitio Sagang","Sitio Sagawin","Sitio Samson","Sitio San Vicente","Sitio Sibucao","Sitio Silot","Sitio Tagum","Sitio Talisay","Sitio Tampi","Sitio Tanban","Sitio Tig-um","Sitio Tongo","Sitio Tubigan","Sitio Ubay","Sitio Uling","Tagamisa","Tagda","Tagyang","Talanghauan","Talaptap","Tambongan","Tangil","Tapi","Tayak","Tinamnan","Tinangwang","Tugas","Ubay","Ubay Kalsada","Vicencio Claro","Villacin","Villahermosa","Vista Alegre","Zone I Poblacion","Zone II Poblacion","Zone III Poblacion","Zone IV Poblacion","Zone V Poblacion","Zone VI Poblacion","Zone VII Poblacion","Zone VIII Poblacion","Zone IX Poblacion","Zone X Poblacion","Zone XI Poblacion",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, magalonaBrgy);
        }
        
        if (selectedCity === 'Escalante City') {
            var escalanteBrgy = [
                "Bagtic","Balintawak","Balintawak (Pob.)","Binaguiohan","Cervantes","Dian-ay","Guimbala-on","Jonobjonob","Langub","Lirongan","Magsaysay","Old Poblacion","Paitan","Paraiso","Patao","Patag","Pinapugasan","Prk. Laga","Rizal","Tamlangon","V.F. Gustilo",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, escalanteBrgy);
        }

        if (selectedCity === 'Himamaylan City') {
            var himamaylanBrgy = [
                "Aguisan","Alejandro Acuña","Ayahay","Balicotoc","Bagtic","Banquerohan","Barangay I (Poblacion)","Barangay II (Poblacion)","Barangay III (Poblacion)","Barangay IV (Poblacion)","Barangay V (Poblacion)","Barangay VI (Poblacion)","Barangay VII (Poblacion)","Barangay VIII (Poblacion)","Barangay IX (Poblacion)","Barangay X (Poblacion)","Barangay XI (Poblacion)","Barangay XII (Poblacion)","Barangay XIII (Poblacion)","Barangay XIV (Poblacion)","Buenavista","Bulwangan","Bunga","Casa Blanca","Carabalan","Caradio-an","Cayang","Colonia","Concepcion","Crampog","Culit","Dancalan","Dos Hermanas","Gargato","Guadalupe","Habag","Hagdang Bato","Haguimit","Hibiano","Hinigaran","Ingay","La Castellana","La Carlota City","Libertad","Linaon","Ma-ao","Macagahay","Mabini","Mabini (Talabahan)","Mambulac","Manasi","Maricalum","Masulog","Nabulao","Nalundan","Natalao","Pag-ayon","Pangihiran","Pansy","Patique","Polo","San Juan","San Lorenzo","San Miguel","San Nicolas","San Pedro","Sasa","Tagda","Talacagay","Tambobo","Tan-awan","Tinungan","Ubay","Valladolid","Yubo",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, himamaylanBrgy);
        }
        
        if (selectedCity === 'Hinigaran') {
            var hinigaranBrgy = [
                "Abaca","Andres Bonifacio","Asia","Bagroy","Basak","Bolisong","Buenavista","Bulwagan","Cansalongon","Carabalan","Carol-an","Dalipdip","Gargato","Guiljungan","Hilamonan","Himaya","Lag-asan","Laguinbanwa","Lalagsan","Linaon","Macalbang","Magsaysay","Maquiling","Matab-ang","Midsalip","Nagbinlod","Nato","Nauhang","Pilar","Polo","Pook","San Antonio","San Enrique","San Francisco","San Jose","San Juan","San Pedro","San Ramon","San Roque","Santa Ana","Santa Clara","Santa Cruz","Santa Isabel","Santa Rosa","Suba","Sulangan","Tabi","Tagda","Tampalon","Tinongan","Ubay","Zamora",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, hinigaranBrgy);
        }
        
        if (selectedCity === 'Hinoba-an') {
            var hinobaAnBrgy = [
                "Damutan", "Talacagay","Bacuyangan","1-Poblacion","2-Poblacion","San Rafael","Pook","Alim","Asia","Bulwangan","Daug","Culipapa","Sangke"
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, hinobaAnBrgy);
        }
        

        if (selectedCity === 'Ilog') {
            var ilogBrgy = [
                "Agpangi","Bantayan","Camalanda-an","Camindangan","Calubang","Dancalan","Dawis","Guinpana-an","Igang","Ilog","Leong","Malocloc Norte","Malocloc Sur","Maño","Mariano","Minalabac","Montilla","Pook","San Antonio","San Juan","San Pedro","San Roque","Santa Rita","Taloc","Tayawan","Tigbalogo","Ubay","Yubo",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, ilogBrgy);
        }
        
        if (selectedCity === 'Isabela') {
            var isabelaBrgy = [
                "Abaca","Aguilar","Balabag","Balabag (Pob.)","Bantayan","Bucana","Burgos","Cabcab","Cabug","Calatagan","Cana-an","Canas","Carbullan","Colonia","Dagohoy","Dahicanan","Danao","Dancalan","Gargato","Guihulngan","Guihulngan (Pob.)","Hinigaran","Hinigaran (Pob.)","Hinolangan","Libertad","Lipayran","Luna","Lupa","Lutay","Mabini","Ma‑ao","Maga‑ay","Magallon","Magsaysay","Magsico","Malingin","Manalongon","Marcelo","Minoyan","Nag‑abaan","Nagbinabang","Nagbalaye","Nagorisican","Nato","Naukay","Naukayan","New Poblacion","Nipa","Pacol","Pali‑an","Pandan","Paralum","Payao","Poblacion","Rizal","Sagit‑na","Salvador Benedicto","Samac","San Agustin","San Antonio","San Carlos","San Juan","San Luis","San Nicolas","San Pedro","San Rafael","San Roque","Santa Ana","Santa Cruz","Sibucao","Simsiman","Sipitan‑b","Sipitan‑p","Sobre‑Montilla","Tahing","Tambol","Tandang Sora","Tib‑ao","Tinongan","Tuburan","Ubos","Upland","Upper Tapitan","Valladolid","Victorias","Villanueva",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, isabelaBrgy);
        }
        

        if (selectedCity === 'Kabankalan City') {
            var kabankalanBrgy = [
                "Aguilar","Balintawak", "Bantayan","Binicuil","Camugao","Dumon","Ilijan","Inapoy","Linao","Magballo","Orong","Tagoc","Talisay","Tampalon","Tan-awan","Tinongan","Ubay","Brgy. 1 (Pob.)",
                "Brgy. 2 (Pob.)","Brgy. 3 (Pob.)","Brgy. 4 (Pob.)","Brgy. 5 (Pob.)","Brgy. 6 (Pob.)","Brgy. 7 (Pob.)","Brgy. 8 (Pob.)","Brgy. 9 (Pob.)","Brgy. 10 (Pob.)","Brgy. 11 (Pob.)","Brgy. 12 (Pob.)","Brgy. 13 (Pob.)","Brgy. 14 (Pob.)","Brgy. 15 (Pob.)","Brgy. 16 (Pob.)","Brgy. 17 (Pob.)","Brgy. 18 (Pob.)","Brgy. 19 (Pob.)","Brgy. 20 (Pob.)","Brgy. 21 (Pob.)","Brgy. 22 (Pob.)","Brgy. 23 (Pob.)","Brgy. 24 (Pob.)","Brgy. 25 (Pob.)","Brgy. 26 (Pob.)","Brgy. 27 (Pob.)","Brgy. 28 (Pob.)","Brgy. 29 (Pob.)","Brgy. 30 (Pob.)","Brgy. 31 (Pob.)","Brgy. 32 (Pob.)","Brgy. 33 (Pob.)","Brgy. 34 (Pob.)","Brgy. 35 (Pob.)","Brgy. 36 (Pob.)","Brgy. 37 (Pob.)","Brgy. 38 (Pob.)","Brgy. 39 (Pob.)","Brgy. 40 (Pob.)","Brgy. 41 (Pob.)","Brgy. 42 (Pob.)","Brgy. 43 (Pob.)","Brgy. 44 (Pob.)","Brgy. 45 (Pob.)","Brgy. 46 (Pob.)","Brgy. 47 (Pob.)","Brgy. 48 (Pob.)","Brgy. 49 (Pob.)","Brgy. 50 (Pob.)",
                "Brgy. 51 (Pob.)","Brgy. 52 (Pob.)","Brgy. 53 (Pob.)","Brgy. 54 (Pob.)","Brgy. 55 (Pob.)","Brgy. 56 (Pob.)","Brgy. 57 (Pob.)","Brgy. 58 (Pob.)","Brgy. 59 (Pob.)","Brgy. 60 (Pob.)","Brgy. 61 (Pob.)","Brgy. 62 (Pob.)","Brgy. 63 (Pob.)","Brgy. 64 (Pob.)","Brgy. 65 (Pob.)","Brgy. 66 (Pob.)","Brgy. 67 (Pob.)","Brgy. 68 (Pob.)","Brgy. 69 (Pob.)","Brgy. 70 (Pob.)","Brgy. 71 (Pob.)","Brgy. 72 (Pob.)","Brgy. 73 (Pob.)","Brgy. 74 (Pob.)","Brgy. 75 (Pob.)","Brgy. 76 (Pob.)","Brgy. 77 (Pob.)","Brgy. 78 (Pob.)","Brgy. 79 (Pob.)","Brgy. 80 (Pob.)","Brgy. 81 (Pob.)","Brgy. 82 (Pob.)","Brgy. 83 (Pob.)","Brgy. 84 (Pob.)","Brgy. 85 (Pob.)","Brgy. 86 (Pob.)","Brgy. 87 (Pob.)","Brgy. 88 (Pob.)","Brgy. 89 (Pob.)","Brgy. 90 (Pob.)","Brgy. 91 (Pob.)","Brgy. 92 (Pob.)","Brgy. 93 (Pob.)","Brgy. 94 (Pob.)","Brgy. 95 (Pob.)","Brgy. 96 (Pob.)","Brgy. 97 (Pob.)","Brgy. 98 (Pob.)","Brgy. 99 (Pob.)","Brgy. 100 (Pob.)",
                "Brgy. 101 (Pob.)","Brgy. 102 (Pob.)","Brgy. 103 (Pob.)","Brgy. 104 (Pob.)","Brgy. 105 (Pob.)","Brgy. 106 (Pob.)","Brgy. 107 (Pob.)","Brgy. 108 (Pob.)","Brgy. 109 (Pob.)","Brgy. 110 (Pob.)","Brgy. 111 (Pob.)","Brgy. 112 (Pob.)","Brgy. 113 (Pob.)","Brgy. 114 (Pob.)","Brgy. 115 (Pob.)","Brgy. 116 (Pob.)","Brgy. 117 (Pob.)","Brgy. 118 (Pob.)","Brgy. 119 (Pob.)","Brgy. 120 (Pob.)","Brgy. 121 (Pob.)","Brgy. 122 (Pob.)","Brgy. 123 (Pob.)","Brgy. 124 (Pob.)","Brgy. 125 (Pob.)","Brgy. 126 (Pob.)","Brgy. 127 (Pob.)","Brgy. 128 (Pob.)","Brgy. 129 (Pob.)","Brgy. 130 (Pob.)","Brgy. 131 (Pob.)","Brgy. 132 (Pob.)","Brgy. 133 (Pob.)","Brgy. 134 (Pob.)","Brgy. 135 (Pob.)","Brgy. 136 (Pob.)","Brgy. 137 (Pob.)","Brgy. 138 (Pob.)","Brgy. 139 (Pob.)","Brgy. 140 (Pob.)","Brgy. 141 (Pob.)","Brgy. 142 (Pob.)","Brgy. 143 (Pob.)","Brgy. 144 (Pob.)","Brgy. 145 (Pob.)","Brgy. 146 (Pob.)","Brgy. 147 (Pob.)","Brgy. 148 (Pob.)","Brgy. 149 (Pob.)","Brgy. 150 (Pob.)",
                "Brgy. 151 (Pob.)","Brgy. 152 (Pob.)","Brgy. 153 (Pob.)","Brgy. 154 (Pob.)","Brgy. 155 (Pob.)","Brgy. 156 (Pob.)","Brgy. 157 (Pob.)","Brgy. 158 (Pob.)","Brgy. 159 (Pob.)","Brgy. 160 (Pob.)","Brgy. 161 (Pob.)","Brgy. 162 (Pob.)","Brgy. 163 (Pob.)","Brgy. 164 (Pob.)","Brgy. 165 (Pob.)","Brgy. 166 (Pob.)","Brgy. 167 (Pob.)","Brgy. 168 (Pob.)","Brgy. 169 (Pob.)","Brgy. 170 (Pob.)","Brgy. 171 (Pob.)","Brgy. 172 (Pob.)","Brgy. 173 (Pob.)",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, kabankalanBrgy);
        }
        
        if (selectedCity === 'La Carlota City') {
            var laCarlotaBrgy = [
                "Baclao","Balabag","Balintawak","Banquerohan","Banza","Batea","Cabaon-an","Cabatangan","Caduhaan","Cubay","Cubay Poblacion","Cubay Ubos","Dumaguete","Haguimit","La Granja","Marinoy","Molocaboc","Palintaon","Poblacion","Ratay","Roberto H. Tirol Pob. (Balicotoc)","San Enrique","Santa Cruz","Yubo",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, laCarlotaBrgy);
        }
        
        if (selectedCity === 'La Castellana') {
            var laCastellanaBrgy = [
                "Abuanan","Cabacungan","Cabagnaan","Cabatangan","Cambayobo","Canlamay","Codcod","Efigenio Lizares","Guinhalaran","Guinpana-an","Lacaron","La Granja","Molobolo","Nagasi","Poblacion","Roberto H. Tirol (Balintawak)","Roberto S. Benedicto","Salamanca","San Enrique","Tubod","Yubo",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, laCastellanaBrgy);
        }
        
        if (selectedCity === 'Manapla') {
            var manaplaBrgy = [
                "Banga","Cubay","Gahit","Latawan","Mambulac","Manapla","Punta Mesa","Royal","San Juan","Santa Rosa","Tamborong",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, manaplaBrgy);
        }
        
        if (selectedCity === 'Moises Padilla') {
            var moisesPadillaBrgy = [
                "Amoscal","Bato","Canroma","Cogon","Guintorilan","Inolingan","Kabac","Luna","Mabini","Mangilay","Marañon","Masulog","Montilla","Nalumdampalay","Palampas","Panginoon","Quinoy‑ogan","San Jose","San Juan","San Pablo","Santa Rosa","Tabao Baybay","Talisay","Zone I (Poblacion)","Zone II (Poblacion)","Zone III (Poblacion)",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, moisesPadillaBrgy);
        }

        if (selectedCity === 'Murcia') {
            var murciaBrgy = [
                "Alegria","Amayco","Aurora","Blumentritt","Cansilayan","Damsite","Kapitan Ramon","Lopez Jaena","Minoyan","Nena","Sta. Cruz","Talotog","Zone I (Poblacion)","Zone II (Poblacion)","Zone III (Poblacion)","Zone IV (Poblacion)","Zone V (Poblacion)","Zone VI (Poblacion)",
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, murciaBrgy);
        }


        if (selectedCity === 'Mabinay') {
            var mabinayBrgy = [
                "Abis", "Arebasore", "Bagtic", "Banban", "Barras", "Bato", "Bugnay", "Bulibulihan", 
                "Bulwang", "Campanun-an", "Canggohob", "Cansal-ing", "Dagbasan", "Dahile", "Hagtu", 
                "Himocdongon", "Inapoy", "Lamdas", "Lumbangan", "Luyang", "Manlingay", "Mayaposi", 
                "Napasu-an", "New Namangka", "Old Namangka", "Pandanon", "Paniabonan", "Pantao", 
                "Poblacion", "Samac", "Tadlong", "Tara"
            ];
        
            brgySelect.append('<option value="">Select Barangay</option>');
            populateOptionsBrgy(brgySelect, mabinayBrgy);
        }
        
        
    });

    // Function to populate select options
    function populateOptionsBrgy(selectElement, options) {
        selectElement.empty();
        selectElement.append('<option value="">Select Barangay</option>');
        for (var i = 0; i < options.length; i++) {
            selectElement.append('<option value="' + options[i] + '">' + options[i] + '</option>');
        }
    }
});