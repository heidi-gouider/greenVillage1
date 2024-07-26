# Village Green - Gestion des Commandes et Facturation

## Description

Village Green est une entreprise de distribution de matériel musical. Elle opère principalement comme grossiste, mais souhaite développer son activité de vente aux particuliers. Ce projet vise à améliorer le système de gestion des commandes et de facturation de l'entreprise en informatisant tout le processus depuis la mise à jour du catalogue jusqu'au paiement.

## Objectifs

- Informatiser le processus de gestion des commandes et de facturation.
- Permettre aux clients de visualiser le catalogue et de passer des commandes en ligne.
- Gérer les relations avec les fournisseurs, y compris la mise à jour du catalogue et du stock.
- Assurer la gestion des clients, des commerciaux et des réductions.
- Générer des bons de livraison et des factures.
- Gérer les adresses de livraison et de facturation.
- Conserver les documents associés aux commandes pendant trois ans.

## Fonctionnalités

- Visualisation du catalogue de produits organisé en Rubriques/Sous-Rubriques.
- Gestion des produits avec des libellés, des références fournisseurs, des prix d'achat et des photos.
- Calcul automatique du prix de vente basé sur un coefficient spécifique à la catégorie du client.
- Gestion des stocks et des publications de produits.
- Attribution des clients à des commerciaux, avec des coefficients de prix ajustables.
- Application de réductions spécifiques pour les clients professionnels.
- Gestion des adresses de livraison et de facturation.
- Génération et conservation des bons de livraison et des factures.
- Paiement à la commande pour les clients particuliers et paiement différé pour les clients professionnels.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- Un serveur de base de données (MySQL, PostgreSQL, etc.)
- Node.js et npm (pour la gestion des assets)

## Installation

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/username/village-green.git
   cd village-green
