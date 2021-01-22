START TRANSACTION;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS USERS;
DROP TABLE IF EXISTS CATEGORIES;
DROP TABLE IF EXISTS MATERIALS;
DROP TABLE IF EXISTS PRODUCTS;
DROP TABLE IF EXISTS PRODUCT_MATERIAL;
DROP TABLE IF EXISTS USER_PRODUCT;
DROP TABLE IF EXISTS QUOTES;
DROP TABLE IF EXISTS QUOTE_PRODUCT;

CREATE TABLE USERS(
    _ID INT AUTO_INCREMENT PRIMARY KEY,
    _NAME VARCHAR(50) NOT NULL,
    _SURNAME VARCHAR(100) NOT NULL,
    _CITY VARCHAR(100) NOT NULL,
    _ADDRESS VARCHAR(100) NOT NULL,
    _CAP CHAR(5) NOT NULL,
    _ADMIN BIT DEFAULT 0,
    _EMAIL VARCHAR(100) NOT NULL UNIQUE,
    _PASSWORD VARCHAR(1024)
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE CATEGORIES(
    _ID INT AUTO_INCREMENT PRIMARY KEY,
    _NAME VARCHAR(100) NOT NULL,
    _DESCRIPTION TEXT NOT NULL,
    _METADESCRIPTION VARCHAR(500) NOT NULL,
    _MENU BIT DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE MATERIALS(
    _ID INT AUTO_INCREMENT PRIMARY KEY,
    _NAME VARCHAR(50) NOT NULL,
    _DESCRIPTION VARCHAR(200) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE PRODUCTS(
    _ID INT AUTO_INCREMENT PRIMARY KEY,
    _NAME VARCHAR(30) NOT NULL,
    _DESCRIPTION TEXT NOT NULL,
    _METADESCRIPTION VARCHAR(500) NOT NULL,
    _DIMENSIONS VARCHAR(300),
    _AGE VARCHAR(50),
    _MAIN_IMAGE VARCHAR(500) NOT NULL,
    _MAIN_IMAGE_DESCRIPTION VARCHAR(200) NOT NULL,
    _CATEGORY INT NOT NULL,
    FOREIGN KEY (_CATEGORY) REFERENCES CATEGORIES(_ID) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE PRODUCT_MATERIAL(
    _MATERIAL_ID INT NOT NULL,
    _PRODUCT_ID INT NOT NULL,
    PRIMARY KEY (_MATERIAL_ID, _PRODUCT_ID),
    FOREIGN KEY (_MATERIAL_ID) REFERENCES MATERIALS(_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (_PRODUCT_ID) REFERENCES PRODUCTS(_ID) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE USER_PRODUCT( /* PRODOTTI VISUALIZZATI E QUANTE VOLTE SON STATI VISUALIZZATI*/
    _QUANTITY INT DEFAULT 1,

    _USER_ID INT NOT NULL,
    _PRODUCT_ID INT NOT NULL,
    PRIMARY KEY (_USER_ID, _PRODUCT_ID),
    FOREIGN KEY(_USER_ID) REFERENCES USERS(_ID)  ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(_PRODUCT_ID) REFERENCES PRODUCTS(_ID) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE QUOTES(
    _ID INT AUTO_INCREMENT PRIMARY KEY,
    _CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    _TELEPHONE VARCHAR(20),
    _REASON TEXT,
    _COMPANY VARCHAR(100),
    
    _USER INT NOT NULL,
    FOREIGN KEY(_USER) REFERENCES USERS(_ID) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

CREATE TABLE QUOTE_PRODUCT(
    _QUANTITY INT DEFAULT 1,

    _QUOTE_ID INT NOT NULL,
    _PRODUCT_ID INT NOT NULL,
    PRIMARY KEY (_QUOTE_ID, _PRODUCT_ID),
    FOREIGN KEY(_QUOTE_ID) REFERENCES QUOTES(_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(_PRODUCT_ID) REFERENCES PRODUCTS(_ID) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `USERS` (`_ID`, `_NAME`, `_SURNAME`, `_CITY`, `_ADDRESS`, `_CAP`, `_ADMIN`, `_EMAIL`, `_PASSWORD`) VALUES
(1, 'admin name', 'admin surname', 'admin city', 'admin address', '10010', b'1', 'admin@admin.admin', 'admin'),
(2, 'Utente', 'Utente', 'Città', 'Via della città', '30010', b'0', 'utente@utente.utente', 'utente');

INSERT INTO `QUOTES` (`_ID`, `_CREATED_AT`, `_TELEPHONE`, `_REASON`, `_COMPANY`, `_USER`) VALUES 
(1, '2021-01-02 19:50:49', '349867369', 'Creazione del parco giochi vicino a casa mia', 'Company SRL', '2');

INSERT INTO `CATEGORIES` (`_ID`, `_NAME`, `_DESCRIPTION`, `_METADESCRIPTION`, `_MENU`) VALUES
(4, 'Arredo Urbano', 'Solid Funicular propone una vasta gamma di prodotti per l’arredo urbano quali panchine da esterno, fontane, cestini porta-rifiuti, rastrelliere, griglie per alberi, pensiline attesa autobus, dissuasori, fioriere, transenne e molti altri complementi.<br />\r\n<br />\r\nFunzionalità, stile e innovazione sono le peculiarità che fanno di ogni articolo una soluzione affidabile, destinata a durare nel tempo e che ben si adatta a contesti architettonici di ogni genere, grazie a un’esperienza ventennale e a un’accurata scelta dei materiali.<br />\r\n<br />\r\nIl nostro staff di arredo urbano è al tuo servizio per migliorare la qualità della vita, rispettando l’ambiente che ci circonda utilizzando anche prodotti riciclati e riciclabili.', 'Arredo Urbano. Prodotti per l’arredo urbano quali panchine da esterno, fontane, cestini portarifiuti, rastrelliere, griglie per alberi, pensiline attesa autobus, dissuasori, fioriere, transenne e molti altri complementi.', b'1'),
(5, 'Arredi in Plastica Riciclata', 'La plastica riciclata è il materiale del futuro, perché garantisce la resistenza nel tempo e alle intemperie senza necessità di manutenzione.\r\nQuesto materiale auto-sviluppato costituisce la base per palizzate, profili a U, travi, traversine e mattoni a L. Inoltre, il materiale di valore secondario può essere utilizzato per profili quadrati, pannelli, lastre e pali nonché profili trasversali. Dissuasori, recinzioni, schermi, ringhiere e barriere sono fabbricati con questo materiale riciclato. Allo stesso modo, è possibile utilizzare terreni, pile di creste, pile guidate, tavole di decking e tavole di paddock.<br />\r\n<br />\r\nLa plastica riciclabile sostenibile offre anche barre per prato, piatti esagonali e piatti per piante infestanti. Inoltre, realizziamo set, panche, tavoli, gruppi di sedute, panche rotonde e assi per panca e naturalmente, accessori per panchine fioriere, letti rialzati e compositori e contenitori per rifiuti.<br />\r\nUltimo ma non meno importante, panche per bambini, tavoli per bambini, sabbiere e tavoli fangosi di questo materiale ecologico. Pertanto, il nostro riciclaggio della plastica garantisce che i materiali da costruzione, i materiali da costruzione, i mobili da esterno e le attrezzature da gioco e l’arredo urbano possano essere prodotti in modo economico, ecologico e resistente.', 'Arredo Urbano in Plastica Riciclata. Prodotti per l’arredo urbano quali panchine, cestini portarifiuti, rastrelliere, dissuasori, fioriere e molti altri complementi in Plastica Riciclata.', b'1'),
(6, 'Cestini Raccolta Differenziata', 'In un’ottica di preservazione dell’ambiente, vengono proposti di seguito cestini per la raccolta differenziata da esterno ed interno che mirano per definizione a garantire una migliore vivibilità delle città, oltre a mantenere un ambiente sano per le generazioni future.<br />\r\n<br />\r\nProporre sempre più soluzioni di contenitori per la raccolta differenziata contribuisce a sensibilizzare i cittadini al tema dell’ecologia e a insegnare a far loro rispettare l’ambiente che li ospita.<br />\r\nCiò che contraddistingue i prodotti proposti a catalogo è sicuramente l’accurata scelta dei materiali, quali polietilene e acciaio, che, oltre a durare nel tempo, permettono di acconsentire a qualunque genere di richiesta o necessità, arrivando anche alla realizzazione su misura.\r\nOgni cestino è personalizzabile nei colori e loghi (con l’applicazione di adesivi o placche) e nelle aperture e capienze (per consentire o impedire l’introduzione di diversi tipi di rifiuti).<br />\r\n<br />\r\nÈ disponibile anche una linea molto speciale di prodotti dedicata interamente ai bambini, finalizzata all’educazione dei piccoli cittadini alla separazione dei rifiuti.', 'I cestini raccolta differenziata di Non Solo Arredo sono pensati per venire incontro ad ogni esigenza. I nostri contenitori o bidoni per la raccolta differenziata semplificano notevolmente la gestione della raccolta.', b'1'),
(7, 'Giochi per parchi', 'I giochi per parchi pubblici di Non Solo Arredo, da molti anni specializzata nel proporre strutture ludiche, comprendono tutti i classici : altalena, il bilico, i giochi a molla, castelli, scivoli, combinati, giochi a tema e casette per i più piccoli, oltre a questi siamo in grado di fornire: campi da gioco multi sportivi, piste da skate, roller e parkour per i ragazzi fino ad arrivare a percorsi vita o fitness dando la possibilità a tutti di divertirsi in modo sano e sicuro.<br />\r\n<br />\r\nIl nostro staff specializzato nella progettazione di giochi da esterno per bambini, grazie anche ai molti corsi TUV frequentati, ti aspetta per offrirti soluzioni innovative sia dal punto di vista ludico che dei materiali utilizzati per permettere al bambino di giocare in completa sicurezza nel rispetto delle normative europee EN1176/77.<br />\r\n<br />\r\nScegli tra la nostra ampia gamma di esterni per bambini.', 'Una vasta serie di giochi per parchi pubblici e giochi da esterno per bambini, per la comunità e non solo. I giochi per parchi sono disponibili in vari materiali e di diverse grandezze. Contattaci per avere maggiori informazioni sui nostri giochi da esterno per bambini.', b'1'),
(8, 'Distributori Gel Igienizzante', 'I dispenser automatici di gel igienizzante per mani sono l’ideale per tutti gli ambienti pubblici come aziende, parchi pubblici, centri commerciali, hotel, cinema e spazi commerciali.<br />\r\nLa nostra colonnina igienizzante mani è disponibile in molti colori e forme, per incontrare qualsiasi esigenza estetica e di necessità.<br />\r\n<br />\r\nIl distributore gel è un elemento di arredo urbano che aiuta a create intorno a te e alle persone a te vicine un ambiente sicuro ed sano, diminuendo drasticamente la proliferazione dei virus.<br />\r\n', 'Dispenser automatici di gel igienizzante per mani, ottimale per aziende, centri commerciali, hotel e luoghi pubblici. Il distributore gel è un elemento ormai necessario e fondamentale per garantire massima sicurezza ai lavoratori ed ai clienti, con un occhio anche al design.', b'0'),
(9, 'Percorso Vita', 'Il nostro Percorso Vita si compone di varie stazioni, con diversi livelli di difficoltà. <br />\r\nÈ diviso in tre categorie a seconda degli utenti: adulti, ragazzi, e per chi ha difficoltà motorie. <br />\r\nDispone anche di App dedicata, che consente di utilizzare al meglio l’attrezzo, e di avere in tempo reale tutti i dati riguardanti il consumo calorico, le istruzioni di utilizzo, e i vari livelli di difficoltÀ da poter eseguire.', 'Il nostro Percorso Vita si compone di varie stazioni, con diversi livelli di difficoltà. È diviso in tre categorie a seconda degli utenti: adulti, ragazzi, e per chi ha difficoltà motorie. Dispone anche di App dedicata, che consente di utilizzare al meglio l’attrezzo, e di avere in tempo reale tutti i dati riguardanti il consumo calorico, le istruzioni di utilizzo, e i vari livelli di difficoltà da poter eseguire.', b'0');

INSERT INTO `PRODUCTS` (`_ID`, `_NAME`, `_DESCRIPTION`, `_METADESCRIPTION`, `_DIMENSIONS`, `_AGE`, `_MAIN_IMAGE`, `_MAIN_IMAGE_DESCRIPTION`, `_CATEGORY`) VALUES
(1, 'VANCOUVER', 'Panche e sedie solide, comode ed ecologiche. Versioni: panche e sedie con 5 o 6 assi e panca. Facile sistema di ancoraggio al suolo. Sono forniti assemblati o smontati. Gambe realizzate in tubo d’acciaio con primer ricco di zinco e tavole di pino tropicale o legno certificato FSC da una fonte responsabile della gestione forestale.', 'VANCOUVER (dim: Con schienale: 180 x 67,7 x h 83 cm\r\nSenza schienale: 180 x 49 x h 63 cm\r\nSedia: 70 x 67 x h 83 cm) della categoria Arredo Urbano è fatta di  legno, perfetto per qualsiasi ambito e luogo.', 'Con schienale: 180 x 67,7 x h 83 cm Senza schienale: 180 x 49 x h 63 cm Sedia: 70 x 67 x h 83 cm', '', '/images/products/5feb1efc3d06f.jpeg', 'Panchina da parco in polietilene', 4),
(2, 'MAVERIK PLASTICO', 'Panchina realizzata in materiale plastico al 100% e completamente riciclabile. Molto resistente agli agenti atmosferici, agli urti e agli atti vandalici, esente dalla corrosione della salsedine del mare ed inattaccabile dalla ruggine. Non si deforma ne si surriscalda al sole e facilmente pulibile da grafiti, polveri o qualsiasi altro deposito. Completamente priva di spigolature e schegge.', 'MAVERIK PLASTICO (dim: Lunghezza: 170 cm / Larghezza: 74,2 cm / h 83 cm) della categoria Arredo Urbano è fatto di  Polietilene HDPE, perfetto per qualsiasi ambito e luogo.\r\n			', 'Lunghezza: 170 cm / Larghezza: 74,2 cm / h 83 cm', '', '/images/products/5feb20fa9cf39.jpeg', 'Panchina da parco color verde in materiale plastico', 4),
(3, 'TENERIFE', 'Cestino composto da lamiera in acciaio zincato a caldo, verniciato a polveri, con nervatura calandrata, corpo basculante e con estremità presso piegate per evitare parti taglienti. Il palo di supporto in tubolare di acciaio con sfera decorativa. Dotato di cupolina anti-pioggia che impedisce l’introduzione di sacchetti ingombranti, oppure senza.', 'TENERIFE (dim: ø 314 × 540 mm \r\nPalo di ancoraggio: ø 60 × 1460 mm\r\nCapacità: 40 Litri) della categoria Arredo Urbano è fatto di  Acciaio Zincato, perfetto per qualsiasi ambito e luogo.', ' ø 314 × 540 mm Palo di ancoraggio: ø 60 × 1460 mm Capacità: 40 Litri', '', '/images/products/5feb2229685db.jpg', 'Cestino di lamiera in acciaio color grigio con paletto di supporto', 4),
(4, 'GINEVRA', 'Portarifiuti stradale, stile GINEVRA, composto da dissuasore in ghisa ornato alla sommità da un pomello sferico; base, chiusa da un collarino di ornamento circolare, predisposta all’ancoraggio fisso in fondazione mediante apposita zoccolatura; cestino in ferro, verniciato a forno con polveri termoindurenti per esterni, ribaltabile ed asportabile stampato a rilievo ed ornato con due serie di fori, ancorato al colonnino nella parte inferiore mediante un braccio e nella parte superiore tramite un gancio di fermo.', 'GINEVRA (dim: ⌀ h. 900 X 220 mm) della categoria Arredo Urbano è fatto di  Ghisa, perfetto per qualsiasi ambito e luogo.', '⌀ h. 900 X 220 mm', '', '/images/products/5feb22e36d620.jpeg', 'Cestino stradale color grigio in ghisa ornato ', 4),
(5, 'OSLO', 'Dissuasore stradale in ghisa, stile OSLO, costituito da un colonnino prismatico cavo di sezione e base ottagonale ornato alla sommità da un pomello sferico. Base ottagonale con apposita zoccolatura per l’ancoraggio fisso in fondazione.', 'OSLO (dim: ⌀ h. 500 x 191 mm, ⌀ h. 700 x 200) della categoria Arredo Urbano è fatto di  Ghisa, perfetto per qualsiasi ambito e luogo.', '⌀ h. 500 x 191 mm, ⌀ h. 700 x 200', '', '/images/products/5feb305c81275.jpeg', 'Dissuasore stradale fatto in ghisa color grigio con base ortogonale e pomello sferico', 4),
(6, 'DIAMANTE', 'Portabici costituito da una rastrelliera in tubolare di ⌀ 20 x 2 mm, opportunamente curvato e rigidamente saldato a due tubolari orizzontali in acciaio con diametro 40 x 2 mm. Nella versione cementata, lateralmente il portabici è sostenuto da due blocchi in calcestruzzo sabbiato da mm 700 x 450 mm. Tutte le parti metalliche sono zincate a caldo e verniciate a polveri di poliestere termoindurenti. Disponibile in versione da 5, 7 o 9 posti.\r\nLa viteria è in acciaio inox. Peso: 180 Kg.', 'DIAMANTE (dim: Senza cemento -  5 posti: 152 x 55 x h 28 cm / 7 posti: 201 x 55 x h 28 cm / 9 posti: 250 x 55 x h 28 cm \r\nCon cemento - 5 posti: 178 x 55 x h 30 cm / 7 posti: 227 x 55 x h 30 cm / 9 posti: 276 x 55 x h 30 cm) della categoria Arredo Urbano è fatto di  Acciaio Inox, Acciaio Zincato, Calcestruzzo, perfetto per qualsiasi ambito e luogo.', 'Senza cemento - 5 posti: 152 x 55 x h 28 cm / 7 posti: 201 x 55 x h 28 cm / 9 posti: 250 x 55 x h 28 cm Con cemento - 5 posti: 178 x 55 x h 30 cm / 7 posti: 227 x 55 x h 30 cm / 9 posti: 276 x 55 x h 30 cm', '', '/images/products/5feb37184599b.jpeg', 'Portabici in acciaio con tubolari', 4),
(7, 'ARCOBICI', 'Attacco per biciclette a forma di arco con segnaletica dipinta. Struttura in tubo d’acciaio zincato (ø 50 mm) verniciato in diversi colori RAL. Installazione tramite gettata in opera. ', 'ARCO BICI (dim: 70 x 85 cm) della categoria Arredo Urbano è fatto di  Acciaio Zincato, perfetto per qualsiasi ambito e luogo.', '70 x 85 cm', '', '/images/products/5feb37ed8eac5.jpeg', 'Attacco a forma di arco in acciaio con incisione bici', 4),
(8, 'MEZZALUNA', 'è realizzato in acciaio zincato a caldo e policarbonato alveolare multistrato.La struttura è costituita da: montanti in tubolare 50x50 mm, una rastrelleria in tubolare di 40x40 mm, integrata con 6 posti bici per ogni singolo modulo, ed elementi reggi-ruota di diametro 20 mm, ancorati a terra tramite l’utilizzo di tasselli. La copertura è autoportante.', 'MEZZALUNA (dim: 300 x 230 x 228.5 cm) della categoria Arredo Urbano è fatto di Acciaio Zincato, Policarbonato, perfetto per qualsiasi ambito e luogo.', ' 300 x 230 x 228.5 cm', '', '/images/products/5feb3874d4eb0.jpeg', 'Struttura coprente biciclette realizzata  in acciaio', 4),
(9, 'GALDANA', 'Fontana realizzata in acciaio verniciato a polveri termoindurenti tramite forno. Il rubinetto è realizzato in ottone ed è temporizzato. Fissaggio mediante gettata in calcestruzzo. Rifinito con vernice nera in ossido di forgia nera.', 'GALDANA (dim: 348 x 579 x h 1004 mm) della categoria Arredo Urbano è fatto di  Acciaio zincato a caldo e verniciato a polvere, Ottone, perfetto per qualsiasi ambito e luogo.\r\n			', '348 x 579 x h 1004 mm', '', '/images/products/5feb4adf39de0.jpeg', 'Fontanella in acciaio con rubineto, colore nero', 4),
(10, 'APRICA', 'Recinzione interamente realizzata in legno di pino silvestre impregnato in autoclave. I piantoni verticali e le correnti orizzontali sono in tondello cilindrico fuori cuore con fori passanti, fissati per mezzo di viteria in acciaio zincato. Possibilità di fornire scarpette per il fissaggio a muretti in calcestruzzo e cappelli copri piantone realizzati in acciaio zincato. Disponibile anche a 3 correnti.', 'APRICA (dim: Altezza 1100 mm \r\nLarghezza 2000 mm) della categoria Arredo Urbano è fatto di  Pino, Legno, perfetto per qualsiasi ambito e luogo.\r\n			', 'Altezza 1100 mm Larghezza 2000 mm', '', '/images/products/5feb4bcc9e43d.jpeg', 'Altezza 1100 mm Larghezza 2000 mm', 9),
(11, 'HIGHLINE', 'Il modello \"High Line\" ha le doghe poste verticalmente, elemento che in combinazione con gli elementi del piede a cubo, crea un look elegante che si fonde armoniosamente in qualsiasi ambiente. Uno stile che convince ancora anche dopo anni con una seduta comoda grazie ai bordi arrotondati.', 'HIGH LINE (dim: 200 x 45 x 45 cm) della categoria Arredi Plastica Riciclata è fatto di  Plastica Riciclata, perfetto per qualsiasi ambito e luogo.\r\n			', '200 x 45 x 45 cm', '', '/images/products/5feb4d6ab16fc.jpg', 'Panchina da esterno color marrone in plastica reciclata ', 5),
(12, 'ELDORADO SUN LOUNGER', 'I lettini sono progettati per una cosa: relax e comfort sotto il sole. Sia da seduto che da sdraiato, sia da solo che in coppia o in gruppo, sdraiarsi sull’Eldorado Sun Lounger è sempre un piacere. Metti i piedi in alto, goditi il ​​paesaggio, segui il tramonto o semplicemente guarda le persone che passano.', 'ELDORADO SUN LOUNGER (dim: Lunghezza: 150 cm \r\nLarghezza: 168 cm \r\nSeduta: 150 x 8 x 4,7 cm) della categoria Arredi Plastica Riciclata è fatto di  Acciaio Zincato, Plastica Riciclata, perfetto per qualsiasi ambito e luogo.\r\n			', 'Lunghezza: 150 cm Larghezza: 168 cm Seduta: 150 x 8 x 4,7 cm', '', '/images/products/5feb4e57a504a.jpg', 'Lunghezza: 150 cm Larghezza: 168 cm Seduta: 150 x 8 x 4,7 cm', 5),
(13, 'SUPREME RECYCLING', 'Panchina con basamento in plastica riciclata, con spessore di 4,7 mm; l’assemblaggio avviene per mezzo di bulloni in acciaio zincato. La panchina è predisposta per il fissaggio a terra mediante tasselli. Versione di colorazione marrone, grigia o verde.', 'SUPREME RECYCLING (dim: 200 x 46 x 81 cm) della categoria Arredi in Plastica Riciclata è fatto di  Plastica Riciclata, perfetto per qualsiasi ambito e luogo.\r\n			', '200 x 46 x 81 cm', '', '/images/products/5feb9a2aea061.jpg', '200 x 46 x 81 cm', 9),
(14, 'GATTON ROUND BENCH', 'La panchina rotonda \"Gatton\" disponibile in una grande e in una piccola variante esagonale. Le parti del sedile e dello schienale sono formate ciascuna da più assi, che allentano l’immagine rispetto alle tavole continue. Le panchine di plastica riciclata sono state testate per decenni. Le proprietà del materiale sintetico riciclato assicurano la robustezza e la longevità. Le panchine di plastica realizzate in plastica secondaria riciclata di alta qualità sono robuste, esenti da manutenzione e si adattano perfettamente a qualsiasi ambiente, sia come panchina da città che panchina del parco o da giardino.', 'GATTON ROUND BENCH (dim: 30 tavole da banco: 10 x 4 cm \r\nmax. Larghezza del sedile per elemento: 150 o 200 cm \r\nAltezza di seduta: 45 cm  \r\nGatton 1: Ø 1  = 300 cm, Ø 2 = 260 cm, Ø 3 = 151 centimetri \r\nGatton 2:  Ø 1 = 400 cm, Ø 2 = 342 cm, Ø 3 = 236 centimetri) della categoria Panchine in Plastica Riciclata  (Arredi Plastica Riciclata) è fatto di  Plastica Riciclata, perfetto per qualsiasi ambito e luogo.', ' 30 tavole da banco: 10 x 4 cm max. Larghezza del sedile per elemento: 150 o 200 cm Altezza di seduta: 45 cm Gatton 1: Ø 1 = 300 cm, Ø 2 = 260 cm, Ø 3 = 151 centimetri Gatton 2: Ø 1 = 400 cm, Ø 2 = 342 cm, Ø 3 = 236 centimetri', '', '/images/products/5feb9b2cbdecb.jpg', 'panchina esagonale in plastica riciclata con buco in centro', 5),
(15, 'STELVIO SET', 'Panchina con tavolo quadrato da esterno in plastica riciclata supportata da un telaio tubolare in acciaio, robusto ed elegante. Per questo si integra perfettamente con l’architettura moderna in paesaggi urbani o commerciali.', 'STELVIO SET (dim: Panchina: 150 x 10 x 4.7 cm Tavolo: 150 x 10 x 4.7 cm Altezza della seduta: 45 cm Altezza del tavolo: 75 cm) della categoria Arredi Plastica Riciclata è fatto di  Acciaio, Plastica Riciclata, perfetto per qualsiasi ambito e luogo. 			', ' Panchina: 150 x 10 x 4.7 cm Tavolo: 150 x 10 x 4.7 cm Altezza della seduta: 45 cm Altezza del tavolo: 75 cm', '', '/images/products/5feb9be03fb8d.jpg', 'set tavolo e panche in plastica riciclata marrone unite da acciaio ', 5),
(16, 'CALERO SET', 'La sua forma fresca e le linee pulite rendono il banco e il set da tavolo \"Calero\" perfetti per ambienti moderni e urbani. Uno dei nostri progetti più audaci, il \"Calero Set\" è perfetto per le scuole, gli uffici governativi locali o i quartieri di affari, ma altrettanto comodo in un parco cittadino o in un giardino privato. Disponibile nei colori: grigio, marrone, marrone scuro, nero, grigio antracite.', 'CALERO SET (dim: 4 profili della panco: 150 x 9 x 9 cm \r\nAltezza seduta: 45 cm \r\n7 profili del tavolo: 150 x 9 x 9 cm \r\nAltezza del tavolo: 75 cm \r\nSuperficie del tavolo: 67 x 150 cm) della categoria Arredi Plastica Riciclata è fatto di  Plastica Riciclata, perfetto per qualsiasi ambito e luogo.', '4 profili della panca: 150 x 9 x 9 cm Altezza seduta: 45 cm 7 profili del tavolo: 150 x 9 x 9 cm Altezza del tavolo: 75 cm Superficie del tavolo: 67 x 150 cm', '', '/images/products/5feb9c918e430.jpg', 'set tavolo e due panche in plastica riciclata marrone', 5),
(17, 'MUSCARI PLANTER', 'Le fioriere devono essere dure, specialmente se hanno lo scopo di abbellire gli spazi pubblici. Non solo le condizioni meteorologiche, gli uccelli, gli animali e le piante stesse prendono il loro pedaggio, ma possono spesso essere gli obiettivi del vandalismo. \"Muscari\" è particolarmente solido e sostanziale.', 'MUSCARI PLANTER (dim: (LxWxH): 130 x 60 x 50 cm) della categoria Arredi Plastica Riciclata è fatto di  Plastica Riciclata, perfetto per qualsiasi ambito e luogo.\r\n			', '(LxWxH): 130 x 60 x 50 cm', '', '/images/products/5feb9d2b6068f.jpg', 'Porta fiori rettangolare in plastica riciclata', 5),
(18, 'IBERIS PLANTER', 'La fioriera \"Iberis\" è disponibile in cinque diversi stili: tre quadrati, due rettangolari. Grazie alla sua forma neutra, poco appariscente e cubica, questa fioriera si integra particolarmente bene in città e ovunque. Un ulteriore vantaggio è l’altezza può essere aumentata con uno strato aggiuntivo.', 'IBERIS PLANTER (dim: Dimensioni quadrate: 70 x 70, 110 x 110 e 140 x 140 cm\r\nDimensioni rettangolari: 110 x 70 e 140 x 110 cm\r\nAltezza: 47 cm\r\nl’altezza può essere aumentata con livelli aggiuntivi) della categoria Arredi Plastica Riciclata è fatto di  Plastica Riciclata, perfetto per qualsiasi ambito e luogo.\r\n			', 'Dimensioni quadrate: 70 x 70, 110 x 110 e 140 x 140 cm Dimensioni rettangolari: 110 x 70 e 140 x 110 cm Altezza: 47 cm l’altezza può essere aumentata con livelli aggiuntivi', '', '/images/products/5feb9daecfe12.jpg', 'fioriera quadrata in plastica riciclata color marrone', 5),
(19, 'ALICANTE', 'Capacità: 45 litri\r\nPersonalizzazione: superficie disponibile per inserimento di simboli grafici o logo\r\nApertura: superiore, tramite sollevamento della copertura\r\nChiave di sicurezza: non disponibile\r\nInterno: anello reggi-sacco a scomparsa\r\nNumero di raccolte: 1\r\nAccessori: kit di fissaggio per creare batterie di 2, 3 o 4 cestini (incluso) sacchetti di plastica', 'ALICANTE (dim: (255 x 255 x 750) mm) della categoria Cestini Raccolta Differenziata è fatto di  Acciaio zincato a caldo e verniciato a polvere, perfetto per qualsiasi ambito e luogo.\r\n			', '(255 x 255 x 750) mm', '', '/images/products/5feb9f624ce26.jpg', 'Set 4 cestini uniti per raccolta differernziata con scritta specifico rifiuto colorata', 6),
(20, 'AMSTERDAM', 'Capacità: 120 litri o 240 litri\r\nPersonalizzazione: superficie disponibile per inserimento di simboli grafici o logo\r\nApertura: frontale, tramite apposito sportello\r\nChiave di sicurezza: triangolare standard inclusa\r\nInterno: contenitore in plastica completamente estraibile (disponibile anche dotato di ruote)\r\nNumero di raccolte: 1\r\nAccessori: ruote - contenitori raccolta liquidi\r\nColori corpo: grigio', 'AMSTERDAM (dim: (535 x 590 x 1010) mm Capacità: 120 litri \r\n(624 x 790 x 1320) mm Capacità: 240 litri) della categoria Cestini Raccolta Differenziata è fatto di  Acciaio Zincato, perfetto per qualsiasi ambito e luoghi.', '(535 x 590 x 1010) mm Capacità: 120 litri', '', '/images/products/5feba0179d1fe.jpg', 'cestino per raccolta differenziata con scritta rifiuto colorata e apertura laterale', 6),
(21, 'ZOE', 'Contenitore per la raccolta delle pile esauste. Il cestino ZOE nasce come contenitore per la raccolta delle deiezioni canine, tuttavia questa versione è stata integrata con ulteriori modelli dedicati ad altri impieghi, come appunto quella della raccolta delle pile esauste.\r\nDotato di apertura frontale con cassetto basculante per impedire l’accesso, o in alternativa disponibile con foro normale.\r\nDotato di cupolina anti pioggia e chiuso su tutti i lati per evitare la fuoriuscita di odori o materiale pericoloso.\r\nDotato di palo a sezione quadra (incluso e verniciato nella stessa colorazione del cestino), o in alternativa fornito per fissaggio a parete o su palo esistente.\r\nChiusura con chiave di sicurezza triangolare.', 'ZOE (dim: 35 x 25 x h 50 cm) della categoria Cestini Raccolta Differenziata è fatto di  Acciaio Zincato, perfetto per qualsiasi ambito e luogo.\r\n			', '35 x 25 x h 50 cm', '', '/images/products/5feba12d574b2.jpeg', 'Contenitore pile esauste color giallo con apertura frontale e cupolina anti pioggia', 9),
(22, 'BATTERIA 60', 'Contenitore per pile esauste disponibile da 60 e 100 litri. Forma cilindrica verticale fondo piano, acciaio zincato anticorrosione per esposizione permanente agli agenti atmosferici, verniciatura esterna con polveri essiccate al forno, colore nero lucido. Fascia adesiva colore bronzo. Coperchio superiore apribile con serratura a chiave con elettrodo positivo in rilievo. Feritoia sagomata per introduzione selettiva di pile e batterie esauste, su corpo contenitore. Scritte di identificazione del rifiuto', 'BATTERIA 60 (dim: 60 litri: ⌀ 40 x 60 cm \r\n100 litri: ⌀ 40 x 84 cm) della categoria Cestini Raccolta Differenziata è fatto di  Acciaio Zincato, perfetto per qualsiasi ambito e luogo.\r\n			', '60 litri: ⌀ 40 x 60 cm 100 litri: ⌀ 40 x 84 cm', '', '/images/products/5feba1cbaf4a6.jpeg', 'Cestino per batterie usate a forma di batteria', 6),
(23, 'FARMACIA ', 'Contenitore per farmaci scaduti a forma rettangolare verticale con angoli frontali arrotondati. Costruzione in acciaio zincato anticorrosione per esposizione permanente agli agenti atmosferici, con verniciatura esterna con polveri essiccate al forno. Colore standard bianco, lavabile e disinfettabile. Versione con portellone posteriore oppure anteriore apribile, con serratura a chiave. Bocchetta superiore di immissione autoscaricante, antiprelievo, di colore nero, con maniglia cromata. Scritta adesiva di identificazione del rifiuto (croce rossa sanitaria). Disponibile con portellone anteriore e posteriore come in foto. Capacità: 30 e 60 litri', 'FARMACIA (dim: 30 litri: 25 x 30 x h 50 cm \r\n60 litri: 42 x 32 x h 60 cm) della categoria Cestini Raccolta Differenziata è fatto di  Acciaio Zincato, perfetto per qualsiasi ambito e luogo.\r\n			', '30 litri: 25 x 30 x h 50 cm 60 litri: 42 x 32 x h 60 cm', '', '/images/products/5feba2751d2ae.jpeg', 'Cestino per raccolta farmaci scaduti bianco con croce farmacia', 6),
(24, 'PENCIL BIN', 'Utilizzo consigliato: Interno - Esterno\r\nCapacità: 70 Litri\r\nPersonalizzazione: Ampia superficie disponibile per l’applicazione di adesivi per l’identificazione della raccolta o scritte, loghi o simboli\r\nApertura: Tramite sgancio e sollevamento della punta della matita, chiave di sicurezza inclusa\r\nInterno: Contenitore in plastica, estraibile facilmente a sollevamento\r\nAccessori: Possibilià di avere il contenitore interno in acciaio\r\nNumero di raccolte a cestino: 1', 'PENCIL BIN (dim: ⌀ 460 mm / h 1100 mm) della categoria Cestini Raccolta Differenziata è fatto di  Polietilene MDPE, perfetto per qualsiasi ambito e luogo.\r\n			', '⌀ 460 mm / h 1100 mm', '', '/images/products/5feba30a05b53.jpg', 'Insieme di cestini per la raccolta differeziata a forma di matite colorate e disposte a cerchio', 6),
(25, 'ACQUA BUDDY', 'Utilizzo consigliato: Interno\r\nCapacità: 55 Litri\r\nPersonalizzazione: Ampia superficie disponibile per l’applicazione di adesivi per l’identificazione della raccolta o scritte, loghi o simboli\r\nApertura: Tramite sollevamento del coperchio colorato\r\nInterno: Contenitore in plastica, estraibile facilmente a sollevamento\r\nNumero di raccolte a cestino: 1', 'ACQUA BUDDY (dim: Pinguino - 55 litri - ⌀ 515 mm / L 595 mm / H 805 mm \r\nDelfino - 55 litri - ⌀ 530 mm / 595 mm / H 825 mm \r\nRana - 75 litri (con contenitore) o 84 litri (con reggisacco) - ⌀ 515 mm / L 595 mm / H 850 mm) della categoria Cestini Raccolta Differenziata è fatto di  Polietilene MDPE, perfetto per qualsiasi ambito e luogo.\r\n			', 'Pinguino - 55 litri - ⌀ 515 mm / L 595 mm / H 805 mm Delfino - 55 litri - ⌀ 530 mm / 595 mm / H 825 mm Rana - 75 litri (con contenitore) o 84 litri (con reggisacco) - ⌀ 515 mm / L 595 mm / H 850 mm', '', '/images/products/5feba3b2456be.jpg', 'Cestini raccolta differenziata a forma di animali', 6),
(26, 'DOGGY BIN', 'Adatto a qualsiasi contesto grazie alla sua linea semplice e sobria ed al suo design moderno. Costituito solo da materiali riciclati con la possibilità di applicarvi adesivi personalizzati o incidere in rilievo il vostro logo. Capacità 40 Litri.', 'DOGGY BIN (dim: ⌀ 390 mm x h 550 mm) della categoria Cestini Raccolta Differenziata è fatto di  Plastica Riciclata, perfetto per qualsiasi ambito e luogo.\r\n			', '⌀ 390 mm x h 550 mm', '', '/images/products/5feba5c49a8dc.jpeg', 'Cestino per rifiuti di cani color arancione con la forma di un cane disegnata davamti', 6),
(27, 'SANI-SET', 'Distributore gel disinfettante e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri\r\nFornito di pedale per utilizzo completamente igenico, senza contatto.\r\nDotato di uno sportello superiore scorrevole con chiusura a chiave di sicurezza, vasca interna in acciaio inox per l’alloggiamento del gel igienizzante con capacità 5 litri e scomparto interno per l’inserimento della scatola di guanti monouso.\r\nSulla parte frontale è applicata la targa informativa in alluminio adesiva.\r\nAutoportante o fissaggio della piastra con tasselli.', 'Distributore gel disinfettante e igineizzante, e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri. Fornito di pedale per utilizzo completamente igenico.', '800 mm x 30 mm x 30 mm', '', '/images/products/5febac0f40cf5.jpeg', 'Distributore gel igenizzante e guanti monouso color antracite con pedalina ', 8),
(28, 'SANI-SET CON VASCHETTA', 'Distributore gel disinfettante e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri\r\nFornito di pedale per utilizzo completamente igenico, senza contatto.\r\nDotato di uno sportello superiore scorrevole con chiusura a chiave di sicurezza, vasca interna in acciaio inox per l’alloggiamento del gel igienizzante con capacità 5 litri e scomparto interno per l’inserimento della scatola di guanti monouso.\r\nSulla parte frontale è applicata la targa informativa in alluminio adesiva.\r\nAutoportante o fissaggio della piastra con tasselli.\r\nDotato di vaschetta.', 'Distributore gel disinfettante e igineizzante, e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri. Fornito di pedale per utilizzo completamente igenico.', '800 mm x 30 mm x 30 mm', '', '/images/products/5feba83ccad54.jpg', 'Distributore gel igenizzante e guanti monouso color antracite con pedalina e vaschetta ', 8),
(29, 'SANI-SET CON CESTINO', 'Distributore gel disinfettante e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri\r\nFornito di pedale per utilizzo completamente igenico, senza contatto.\r\nDotato di uno sportello superiore scorrevole con chiusura a chiave di sicurezza, vasca interna in acciaio inox per l’alloggiamento del gel igienizzante con capacità 5 litri e scomparto interno per l’inserimento della scatola di guanti monouso.\r\nSulla parte frontale è applicata la targa informativa in alluminio adesiva.\r\nAutoportante o fissaggio della piastra con tasselli.', 'Distributore gel disinfettante e igineizzante, e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri. Fornito di pedale per utilizzo completamente igenico.', '800 mm x 30 mm x 60 mm', '', '/images/products/5febac22eb023.jpeg', 'Distributore gel igenizzante e guanti monouso color antracite con pedalina e cestino', 8),
(30, 'SANI-SET VASCHETTA E CESTINO', 'Distributore gel disinfettante e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri\r\nFornito di pedale per utilizzo completamente igenico, senza contatto.\r\nDotato di uno sportello superiore scorrevole con chiusura a chiave di sicurezza, vasca interna in acciaio inox per l’alloggiamento del gel igienizzante con capacità 5 litri e scomparto interno per l’inserimento della scatola di guanti monouso.\r\nSulla parte frontale è applicata la targa informativa in alluminio adesiva.\r\nAutoportante o fissaggio della piastra con tasselli.\r\nDotato di vaschetta e cestino.', 'Distributore gel disinfettante e igineizzante, e distributore di guanti monouso realizzato in lamiera di acciaio zincato a caldo e verniciato a polveri. Fornito di pedale per utilizzo completamente igenico.', '800 mm x 30 mm x 60 mm', '', '/images/products/5febacc5d8b39.jpeg', 'Distributore gel igenizzante e guanti monouso color antracite con pedalina, vaschetta e cestino', 8),
(31, 'BALANCE BEAM', 'Barra per esercizio di equilibrio', 'BALANCE BEAM (dim: 301 x 10 cm) della categoria Percorso Vita è fatto di  Acciaio, perfetto per qualsiasi ambito e luogo.\r\n			', '301 x 10 cm', '14+', '/images/products/5fec444ec0bdb.jpg', '301 x 10 cm', 9),
(32, 'BODY CURL', 'Panca esercizi per addominali e dorsali', 'BODY CURL (dim: 122 x 50 x 80 cm) della categoria Percorso Vita è fatto di  Acciaio Galvanizzato, perfetto per qualsiasi ambito e luogo.\r\n			', '122 x 50 x 80 cm', '14+', '/images/products/5fec44f96fd47.jpg', '122 x 50 x 80 cm', 9),
(33, 'OSTACOLI GAMBE', 'Il Percorso Salute nasce dalla collaborazione tra tecnici e qualificati istruttori di educazione fisica. Questo è uno dei 23 esercizi per saltare superando gli ostacoli. Questo esercizio ci consente di consumare molte calorie e alzare il nostro battito cardiaco. Consente di contribuire a mantenere un buon livello di salute aumentando la qualità generale della vita. Può essere praticato sia da adulti che da bambini e anche da anziani.Tutti gli elementi del percorso salute vengono realizzati con legno di pino impregnato in autoclave con sali ecologici, per garantirne la massima sicurezza e durata nel tempo. ', 'OSTACOLI GAMBE (dim: 139.5 x 9.5 x 130 cm) della categoria Percorso Vita è fatto di  Pino, Legno, perfetto per qualsiasi ambito e luogo.\r\n			', ' 139.5 x 9.5 x 130 cm', 'Adatto a tutte le età', '/images/products/5fec462755392.jpg', 'Ostacoli da saltare fatti in legno con palo per spiegazione', 9),
(34, 'STRECHING BRACCIA', 'il Percorso Salute nasce dalla collaborazione tra tecnici e qualificati istruttori di educazione fisica. Questo è uno dei 23 esercizi e va fatto a gambe divaricate e mani ai fianchi piegare alternativamente gamba dx e sx. Può essere praticato sia da adulti che da bambini e anche da anziani.Tutti gli elementi del percorso salute vengono realizzati con legno di pino impregnato in autoclave con sali ecologici, per garantirne la massima sicurezza e durata nel tempo.', 'STRECHING BRACCIA (dim: 200 x 10 x 250 cm) della categoria Percorso Vita è fatto di  Pino, Legno, perfetto per qualsiasi ambito e luogo.\r\n			', '200 x 10 x 250 cm', 'Adatto a tutte le età', '/images/products/5fec470ef29bc.jpg', 'tre pali verticali in legno per streching braccia con targhetta per spiegazione allenamento', 9),
(35, 'ANGEL CASCADE', 'Esercizio di arrampicata su corda.', 'ANGEL CASCADE (dim: 409 x 25 x 236 cm) della categoria Percorso Vita è fatto di  Acciaio, Corde, Gomma, Nylon, perfetto per qualsiasi ambito e luogo.\r\n			', '409 x 25 x 236 cm', '5-12 anni', '/images/products/5fec47b55d86a.jpg', 'Arco in acciaio con corfe intrecciate per arrampicarsi', 9),
(36, 'LOBSTER POT', 'Esercizio di di arrampicata su corda incrociato.', 'LOBSTER POT (dim: 359 x 359 x 235 cm) della categoria Percorso Vita è fatto di  Acciaio Galvanizzato, Corde, Nylon, perfetto per qualsiasi ambito e luogo.\r\n			', '359 x 359 x 235 cm', '5-12 anni', '/images/products/5fec492f2a1e0.jpg', 'Archi incrociati in acciaio con corfe intrecciate per arrampicarsi', 9),
(37, 'LED SINGLE', 'Altalena singola per bambini fatta in acciaio.', 'LED SINGLE (dim: 223x227x224 cm) della categoria Giochi iper parchi è fatto di  Acciaio Galvanizzato, perfetto per qualsiasi ambito e luogo.\r\n			', '223x227x224 cm', 'Adatto a tutte le età', '/images/products/5fec4a64585a8.jpg', 'Altalena singola per bambini fatta in acciaio', 7),
(38, 'LED DOUBLE', 'Altalena doppia per bambini in acciaio.', 'LED DOUBLE (dim: 334x227x224 cm) della categoria Giochi per parchi è fatto di  Acciaio Galvanizzato, perfetto per qualsiasi ambito e luogo.\r\n			', '334x227x224 cm', 'Adatto a tutte le età', '/images/products/5fec4ae52088e.jpg', 'Altalena doppia per bambini in acciaio.', 7),
(39, 'BABY', 'Altalena baby singola costituita da due montanti, con seggiolino a culla.', 'BABY (dim: 164x35x199 cm) della categoria Giochi per parchi è fatto di  Acciaio Galvanizzato, perfetto per qualsiasi ambito e luogo.\r\n			', '164x35x199 cm', '1-3 anni', '/images/products/5fec4b7dd6f98.jpg', 'Altalena baby singola costituita da due montanti in acciaio, con seggiolino a culla.', 7),
(40, 'ANA', 'Casetta per bambini con pannelli gioco. Le case da gioco offrono spesso un ambiente ideale per il gioco di ruolo che è così importante per lo sviluppo dei bambini. In concomitanza con il gioco di ruolo, i bambini esplorano diverse possibilità, imparano le regole sociali e il modo di scendere a compromessi e imparano come negoziare e risolvere i conflitti. Il gioco di ruolo richiede anche collaborazione e comunicazione.', 'ANA (dim: 146 x 141 x 166 cm) della categoria Giochi per parchi è fatto di  Polietilene HDPE, Acciaio, perfetto per qualsiasi ambito e luogo.\r\n			', '146 x 141 x 166 cm', '1+', '/images/products/5fec4c1ea0a91.jpg', 'Casetta per bambini da parco color marrone con tavolino e panche al suo interno', 7),
(41, 'LUXI', '\"Luxi\" è uno dei due villaggi di gioco dove i le case gioco si uniscono per creare ambienti più grandi. Il villaggio dei giochi consente di dividere i casolari in zone, in modo che molti bambini possano giocare insieme in luoghi diversi intorno ai casolari senza disturbarsi a vicenda. I villaggi dei giochi sono molto pratici, ad esempio, nelle istituzioni, dove le casette devono ospitare un gran numero di bambini. Il villaggio del gioco ospita molte attività diverse, offrendo opportunità di concentrazione e giochi di ruolo, supportando allo stesso tempo lo sviluppo creativo, sociale, motorio e cognitivo dei bambini. ', 'LUXI (dim: 540 x 540 x 166 cm) della categoria Giochi per parchi è fatto di  Acciaio Zincato perfetto per qualsiasi ambito e luogo.\r\n			', '540 x 540 x 166 cm', '1+', '/images/products/5fec4e6b36add.jpeg', 'due casette da gioco per bambini collegate da un tubo color verde dove i bambini possono giocare', 7),
(42, 'LED SAND 16', 'Sabbiera con 16 sedute da bambini', 'LED SAND 16 (dim: 520 x 520 x 30 cm) della categoria Giochi per bambini è fatto di  Polietilene HDPE, Acciaio Galvanizzato, perfetto per qualsiasi ambito e luogo.', ' 520 x 520 x 30 cm', '1+', '/images/products/5fec4f21c5c4d.jpg', 'Sabbiera per bambini quadrata, colorata con 16 postazioni', 7);

INSERT INTO `MATERIALS` (`_ID`, `_NAME`, `_DESCRIPTION`) VALUES
(1, 'Plastica riciclata', 'Materiale di origine organico a elevato peso molecolare, che determinano in modo essenziale il quadro specifico delle caratteristiche dei materiali stessi.'),
(2, 'Acciaio Zincato', 'Questo metallo si unisce alle capacità di resistenza del ferro, la resistenza alla corrosione dello zinco; la resistenza alla corrosione sarà tanto maggiore quanto lo spessore della zincatura'),
(3, 'Ghisa', 'lega ferrosa costituita principalmente da ferro e carbonio con tenore di carbonio relativamente alto, ottenuta per riduzione o trattamento a caldo dei minerali di ferro.'),
(4, 'Calcestruzzo', 'Il calcestruzzo è un materiale da costruzione, conglomerato artificiale costituito da una miscela di legante, acqua e aggregati fini e grossi '),
(5, 'Policarbonato', 'Materiale termoplastico molto utilizzato in campo edile e nella realizzazione di vetrate data la sua eccellente resistenza agli urti, la chiarezza ottica e l’ampio range di temperatura d’esercizio.'),
(6, 'Legno', 'Il legno è il tessuto vegetale che costituisce il fusto delle piante aventi crescita secondaria (albero, arbusto, liana ed alcune erbe).'),
(7, 'Polietilene MDPE', 'Il polietilene (noto anche come politene) è il più semplice dei polimeri sintetici ed è la più comune fra le materie plastiche'),
(8, 'Acciaio Galvanizzato', 'innanzitutto il materiale da trattare è adeguatamente preparato . Subito dopo  il materiale è immerso in una soluzione elettrolitica contenente sali di zinco');


INSERT INTO `PRODUCT_MATERIAL` (`_MATERIAL_ID`, `_PRODUCT_ID`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(3, 3),
(3, 4),
(3, 5),
(2, 6),
(4, 6),
(2, 7),
(2, 8),
(5, 8),
(2, 9),
(3, 9),
(6, 10),
(1, 11),
(6, 11),
(1, 12),
(2, 12),
(1, 13),
(2, 13),
(5, 13),
(1, 14),
(6, 14),
(1, 15),
(2, 15),
(1, 16),
(2, 16),
(1, 17),
(2, 17),
(1, 18),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(7, 25),
(2, 26),
(7, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(6, 31),
(8, 32),
(2, 33),
(6, 33),
(6, 34),
(2, 35),
(5, 35),
(1, 36),
(2, 36),
(2, 37),
(2, 38),
(1, 39),
(2, 39),
(1, 40),
(2, 40),
(7, 40),
(1, 41),
(2, 41),
(5, 41),
(1, 42);

INSERT INTO `QUOTE_PRODUCT` (`_QUANTITY`, `_QUOTE_ID`, `_PRODUCT_ID`) VALUES
(5, 1, 6),
(1, 1, 13),
(3, 1, 15),
(4, 1, 23);

COMMIT;
