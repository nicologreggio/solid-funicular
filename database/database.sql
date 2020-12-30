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
(1, 'admin name', 'admin surname', 'admin city', 'admin address', '10010', b'1', 'admin@admin.admin', 'admin');

INSERT INTO `CATEGORIES` (`_ID`, `_NAME`, `_DESCRIPTION`, `_METADESCRIPTION`, `_MENU`) VALUES
(4, 'Arredo Urbano', 'Solid Funicular propone una vasta gamma di prodotti per l’arredo urbano quali panchine da esterno, fontane, cestini porta-rifiuti, rastrelliere, griglie per alberi, pensiline attesa autobus, dissuasori, fioriere, transenne e molti altri complementi.<br>\r\n<br>\r\nFunzionalità, stile e innovazione sono le peculiarità che fanno di ogni articolo una soluzione affidabile, destinata a durare nel tempo e che ben si adatta a contesti architettonici di ogni genere, grazie a un’esperienza ventennale e a un’accurata scelta dei materiali.<br>\r\n<br>\r\nIl nostro staff di arredo urbano è al tuo servizio per migliorare la qualità della vita, rispettando l’ambiente che ci circonda utilizzando anche prodotti riciclati e riciclabili.', 'Arredo Urbano. Prodotti per l’arredo urbano quali panchine da esterno, fontane, cestini portarifiuti, rastrelliere, griglie per alberi, pensiline attesa autobus, dissuasori, fioriere, transenne e molti altri complementi.', b'1'),
(5, 'Arredi in Plastica Riciclata', 'La plastica riciclata è il materiale del futuro, perché garantisce la resistenza nel tempo e alle intemperie senza necessità di manutenzione.\r\nQuesto materiale auto-sviluppato costituisce la base per palizzate, profili a U, travi, traversine e mattoni a L. Inoltre, il materiale di valore secondario può essere utilizzato per profili quadrati, pannelli, lastre e pali nonché profili trasversali. Dissuasori, recinzioni, schermi, ringhiere e barriere sono fabbricati con questo materiale riciclato. Allo stesso modo, è possibile utilizzare terreni, pile di creste, pile guidate, tavole di decking e tavole di paddock.<br>\r\n<br>\r\nLa plastica riciclabile sostenibile offre anche barre per prato, piatti esagonali e piatti per piante infestanti. Inoltre, realizziamo set, panche, tavoli, gruppi di sedute, panche rotonde e assi per panca e naturalmente, accessori per panchine fioriere, letti rialzati e compositori e contenitori per rifiuti.<br>\r\nUltimo ma non meno importante, panche per bambini, tavoli per bambini, sabbiere e tavoli fangosi di questo materiale ecologico. Pertanto, il nostro riciclaggio della plastica garantisce che i materiali da costruzione, i materiali da costruzione, i mobili da esterno e le attrezzature da gioco e l’arredo urbano possano essere prodotti in modo economico, ecologico e resistente.', 'Arredo Urbano in Plastica Riciclata. Prodotti per l’arredo urbano quali panchine, cestini portarifiuti, rastrelliere, dissuasori, fioriere e molti altri complementi in Plastica Riciclata.', b'1'),
(6, 'Cestini Raccolta Differenziata', 'In un’ottica di preservazione dell’ambiente, vengono proposti di seguito cestini per la raccolta differenziata da esterno ed interno che mirano per definizione a garantire una migliore vivibilità delle città, oltre a mantenere un ambiente sano per le generazioni future.<br>\r\n<br>\r\nProporre sempre più soluzioni di contenitori per la raccolta differenziata contribuisce a sensibilizzare i cittadini al tema dell’ecologia e a insegnare a far loro rispettare l’ambiente che li ospita.<br>\r\nCiò che contraddistingue i prodotti proposti a catalogo è sicuramente l’accurata scelta dei materiali, quali polietilene e acciaio, che, oltre a durare nel tempo, permettono di acconsentire a qualunque genere di richiesta o necessità, arrivando anche alla realizzazione su misura.\r\nOgni cestino è personalizzabile nei colori e loghi (con l’applicazione di adesivi o placche) e nelle aperture e capienze (per consentire o impedire l’introduzione di diversi tipi di rifiuti).<br>\r\n<br>\r\nÈ disponibile anche una linea molto speciale di prodotti dedicata interamente ai bambini, finalizzata all’educazione dei piccoli cittadini alla separazione dei rifiuti.', 'I cestini raccolta differenziata di Non Solo Arredo sono pensati per venire incontro ad ogni esigenza. I nostri contenitori o bidoni per la raccolta differenziata semplificano notevolmente la gestione della raccolta.', b'1'),
(7, 'Giochi per parchi', 'I giochi per parchi pubblici di Non Solo Arredo, da molti anni specializzata nel proporre strutture ludiche, comprendono tutti i classici : altalena, il bilico, i giochi a molla, castelli, scivoli, combinati, giochi a tema e casette per i più piccoli, oltre a questi siamo in grado di fornire: campi da gioco multi sportivi, piste da skate, roller e parkour per i ragazzi fino ad arrivare a percorsi vita o fitness dando la possibilità a tutti di divertirsi in modo sano e sicuro.<br>\r\n<br>\r\nIl nostro staff specializzato nella progettazione di giochi da esterno per bambini, grazie anche ai molti corsi TUV frequentati, ti aspetta per offrirti soluzioni innovative sia dal punto di vista ludico che dei materiali utilizzati per permettere al bambino di giocare in completa sicurezza nel rispetto delle normative europee EN1176/77.<br>\r\n<br>\r\nScegli tra la nostra ampia gamma di esterni per bambini.', 'Una vasta serie di giochi per parchi pubblici e giochi da esterno per bambini, per la comunità e non solo. I giochi per parchi sono disponibili in vari materiali e di diverse grandezze. Contattaci per avere maggiori informazioni sui nostri giochi da esterno per bambini.', b'1'),
(8, 'Distributori Gel Igienizzante', 'I dispenser automatici di gel igienizzante per mani sono l’ideale per tutti gli ambienti pubblici come aziende, parchi pubblici, centri commerciali, hotel, cinema e spazi commerciali.<br>\r\nLa nostra colonnina igienizzante mani è disponibile in molti colori e forme, per incontrare qualsiasi esigenza estetica e di necessità.<br>\r\n<br>\r\nIl distributore gel è un elemento di arredo urbano che aiuta a create intorno a te e alle persone a te vicine un ambiente sicuro ed sano, diminuendo drasticamente la proliferazione dei virus.<br>\r\n', 'Dispenser automatici di gel igienizzante per mani, ottimale per aziende, centri commerciali, hotel e luoghi pubblici. Il distributore gel è un elemento ormai necessario e fondamentale per garantire massima sicurezza ai lavoratori ed ai clienti, con un occhio anche al design.', b'0'),
(9, 'Percorso Vita', 'Il nostro Percorso Vita si compone di varie stazioni, con diversi livelli di difficoltà. <br>\r\nÈ diviso in tre categorie a seconda degli utenti: adulti, ragazzi, e per chi ha difficoltà motorie. <br>\r\nDispone anche di App dedicata, che consente di utilizzare al meglio l’attrezzo, e di avere in tempo reale tutti i dati riguardanti il consumo calorico, le istruzioni di utilizzo, e i vari livelli di difficoltÀ da poter eseguire.', 'Il nostro Percorso Vita si compone di varie stazioni, con diversi livelli di difficoltà. È diviso in tre categorie a seconda degli utenti: adulti, ragazzi, e per chi ha difficoltà motorie. Dispone anche di App dedicata, che consente di utilizzare al meglio l’attrezzo, e di avere in tempo reale tutti i dati riguardanti il consumo calorico, le istruzioni di utilizzo, e i vari livelli di difficoltà da poter eseguire.', b'0');

COMMIT;
