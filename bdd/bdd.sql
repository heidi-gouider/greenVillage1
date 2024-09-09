-- DROP DATABASE VillageGreen;

-- CREATE DATABASE VillageGreen;

USE VillageGreen;

CREATE TABLE Produit(
   Id_produit INT AUTO_INCREMENT,
   libelle_produit VARCHAR(255) ,
   description_produit VARCHAR(255) ,
   prix_achat_HT INT,
   prix INT,
   photo VARCHAR(500),
   stock_quantite INT,
   PRIMARY KEY(Id_produit)
);


CREATE TABLE Categorie(
   Id_Categorie INT AUTO_INCREMENT,
   libelle_categorie VARCHAR(255) ,
   description_categorie VARCHAR(255) ,
   parent_categorie INT AUTO_INCREMENT ,
   PRIMARY KEY(Id_Categorie) ,
    FOREIGN KEY(Id_parent_categorie) REFERENCES categorie(Id_parent_categorie) 
);

INSERT INTO `categorie` (`parent_categorie_id`, `libelle_categorie`, `description_categorie`, `image_categorie`) VALUES
	(NULL, 'Accessoires', 'Tous nos accessoires pour la musique', 'IMG/cable_fond.webp'),
   	(11, 'Les cables', 'Tous les cables pour vos instruments', 'IMG/cable.webp'),
         	(11, 'Les caques', 'Tous les casques', 'IMG/casque.webp')


CREATE TABLE Fournisseur(
   Id_Fournisseur INT AUTO_INCREMENT,
   reference_fournisseur VARCHAR(150) ,
   nom_fournisseur VARCHAR(150) ,
   adresse_fournisseur VARCHAR(255) ,
   telephone VARCHAR(50) ,
   PRIMARY KEY(Id_Fournisseur)
);

CREATE TABLE Client(
   Id_client INT AUTO_INCREMENT,
   categorie_client VARCHAR(255) ,
   nom_client VARCHAR(255) ,
   prenom_client VARCHAR(255) ,
   raison_social VARCHAR(255) ,
   coef_client INT,
   reduction_accordee INT,
   telephone VARCHAR(50) ,
   Id_commercial INT NOT NULL,
   PRIMARY KEY(Id_client),
   FOREIGN KEY(Id_commercial) REFERENCES Commercial(Id_commercial)
);

CREATE TABLE Commande(
   Id_Commande INT AUTO_INCREMENT,
   statut_lvraison VARCHAR(255) ,
   date_commande DATE,
   reduction INT,
   mode_reglement VARCHAR(255) ,
   date_reglement DATE,
   nb_expedition INT,
   Id_Facture INT NOT NULL,
   PRIMARY KEY(Id_Commande),
   FOREIGN KEY(Id_Facture) REFERENCES Facture(Id_Facture)
);

CREATE TABLE Bon_de_livraison(
   Id_bon_de_livraison INT AUTO_INCREMENT,
   liste_produit VARCHAR(255) ,
   quantite_produit INT,
   description_produit VARCHAR(255) ,
   adresse_livraison VARCHAR(255) ,
   nom_client VARCHAR(255) ,
   date_commande DATE,
   date_livraison DATE,
   lieu_immatriculation VARCHAR(255) ,
   numero_rcs VARCHAR(150) ,
   Id_Commande INT NOT NULL,
   PRIMARY KEY(Id_bon_de_livraison),
   FOREIGN KEY(Id_Commande) REFERENCES Commande(Id_Commande)
);

CREATE TABLE Panier(
   Id_panier INT AUTO_INCREMENT,
   id_produit VARCHAR(50) ,
   quantite_produit INT,
   total_HT INT,
   reduction INT,
   total_TTC INT,
   Id_Commande INT NOT NULL,
   Id_client INT NOT NULL,
   PRIMARY KEY(Id_panier),
   FOREIGN KEY(Id_Commande) REFERENCES Commande(Id_Commande),
   FOREIGN KEY(Id_client) REFERENCES Client(Id_client)
);

CREATE TABLE Regarde(
   Id_produit INT,
   Id_client INT,
   PRIMARY KEY(Id_produit, Id_client),
   FOREIGN KEY(Id_produit) REFERENCES Produit(Id_produit),
   FOREIGN KEY(Id_client) REFERENCES Client(Id_client)
);

CREATE TABLE selectionne(
   Id_produit INT,
   Id_client INT,
   PRIMARY KEY(Id_produit, Id_client),
   FOREIGN KEY(Id_produit) REFERENCES Produit(Id_produit),
   FOREIGN KEY(Id_client) REFERENCES Client(Id_client)
);

CREATE TABLE est_categorisé(
   Id_produit INT,
   Id_produit_1 INT,
   rubrique VARCHAR(150) ,
   sous_rubrique VARCHAR(150) ,
   PRIMARY KEY(Id_produit, Id_produit_1),
   FOREIGN KEY(Id_produit) REFERENCES Produit(Id_produit),
   FOREIGN KEY(Id_produit_1) REFERENCES Produit(Id_produit)
);

CREATE TABLE a(
   Id_Commande INT,
   Id_Adresse INT,
   PRIMARY KEY(Id_Commande, Id_Adresse),
   FOREIGN KEY(Id_Commande) REFERENCES Commande(Id_Commande),
   FOREIGN KEY(Id_Adresse) REFERENCES Adresse(Id_Adresse)
);

CREATE TABLE vend(
   Id_produit INT,
   Id_Fournisseur INT,
   PRIMARY KEY(Id_produit, Id_Fournisseur),
   FOREIGN KEY(Id_produit) REFERENCES Produit(Id_produit),
   FOREIGN KEY(Id_Fournisseur) REFERENCES Fournisseur(Id_Fournisseur)
);

CREATE TABLE indique(
   Id_bon_de_livraison INT,
   Id_Adresse INT,
   PRIMARY KEY(Id_bon_de_livraison, Id_Adresse),
   FOREIGN KEY(Id_bon_de_livraison) REFERENCES Bon_de_livraison(Id_bon_de_livraison),
   FOREIGN KEY(Id_Adresse) REFERENCES Adresse(Id_Adresse)
);

CREATE TABLE renseigne(
   Id_Facture INT,
   Id_Adresse INT,
   PRIMARY KEY(Id_Facture, Id_Adresse),
   FOREIGN KEY(Id_Facture) REFERENCES Facture(Id_Facture),
   FOREIGN KEY(Id_Adresse) REFERENCES Adresse(Id_Adresse)
);

CREATE TABLE Commercial(
   Id_commercial INT AUTO_INCREMENT,
   nom_commercial VARCHAR(255) ,
   prenom_commercial VARCHAR(255) ,
   PRIMARY KEY(Id_commercial)
);

CREATE TABLE Facture(
   Id_Facture INT AUTO_INCREMENT,
   reference VARCHAR(150) ,
   designation VARCHAR(150) ,
   prix_un_HT INT,
   quantite_produit INT,
   total_HT INT,
   TVA INT,
   total_TTC INT,
   PRIMARY KEY(Id_Facture)
);

CREATE TABLE Adresse(
   Id_Adresse INT AUTO_INCREMENT,
   adresse_client VARCHAR(255) ,
   adresse_facturation VARCHAR(255) ,
   adresse_livraison VARCHAR(255) ,
   PRIMARY KEY(Id_Adresse) ,
);
