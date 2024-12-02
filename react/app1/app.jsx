import React, { useEffect, useState } from 'react';
import SearchBar from '../components/searchBarComponent';
// import { Link } from "react-router-dom";
// import { BrowserRouter as Router, Route, Routes, Link } from 'react-router-dom';



const App1 = () => {
    const [categories, setCategories] = useState([]);
    // const [produits, setProduits] = useState([]);
    // const [filteredCategories, setFilteredCategories] = useState([]);
    
        // Attention modification dans api_platform.yalm & framework.yaml pour les limites de jointure et la profondeur de sérialisation

    useEffect(() => {
        // Simulation de récupération des categories depuis une API pour la recherche et/ou le tableau
        // Appel de l'API
    fetch("https://127.0.0.1:8000/api/categories")
        // fetch('/api/categories')
            .then(response => response.json())
            // .then(data => setCategories(data));
            .then(data => {
                console.log("Catégories récupérées :", data);                 
                // setCategories(data["hydra:member"] || []);

                // Formater les données récupérées
            //     const formattedData = data.member.map(cat => ({
            //         nom: cat.libelle_categorie,
            //         description: cat.description_categorie,
            //     })
            // );

                // Mettre à jour l'état avec les catégories formatées
                // setCategories(formattedData);
                // setFilteredCategories(formattedData); // Initialisation avec toutes les catégories
                // setFilteredCategories(data["hydra:member"] || []);
                setCategories(data["hydra:member"] || []);
                // setCategories(Array.isArray(data.member) ? data.member : []);
            })
            .catch(error => console.error("Erreur de récupération des données :", error));

    }, []);

    // useEffect(() => {
        // Simulation de récupération des produits depuis une API pour la recherche et/ou le tableau
        // fetch('/api/produits')
            // .then(response => response.json())
            // .then(data => setProduits(data))
            // .then(data => {

            //     console.log("produits récupérées :", data); 

            //     const formattedData = data.member.map(prod => ({
            //         nom: prod.libelle_produit,
                    // description: prod.description_produit,
                    // quantite: prod.quantite_stock,
            //     })
            // );
            // setProduits(Array.isArray(data.member) ? data.member : []);

                // setProduits(formattedData);
                // setFilteredCategories(formattedData); // Initialisation avec toutes les catégories
                 // Vérifier si 'data' contient bien 'hydra:member' et s'il s'agit d'un tableau
                //  if (Array.isArray(data['hydra:member'])) {
                //     const formattedData = data['hydra:member'].map(prod => ({
                //         nom: prod.libelle_produit,
                //         description: prod.description_produit,
                //         quantite: prod.quantite_stock,
                //     }));

                    // Mettre à jour l'état avec les produits formatés
                //     setProduits(formattedData);
                // } else {
                //     console.error("Format des produits inattendu");
                // }
    //         })
    //         .catch(error => console.error("Erreur de récupération des données :", error));

    // }, []);


    // const fetchProduits = async () => {
    //     // Effectuer le fetch pour récupérer tous les produits
    //     const apiUrl = `/api/produits`; // L'URL pour récupérer tous les produits

    //     try {
    //         const response = await fetch(apiUrl);
    //         if (!response.ok) {
    //             throw new Error('Erreur lors de la récupération des produits');
    //         }
    //         const data = await response.json();
    //         setProduits(data); // Mettre à jour l'état avec les produits récupérés
    //     } catch (error) {
    //         console.error("Erreur de récupération des produits :", error);
    //         setProduits([]); // Réinitialiser les produits en cas d'erreur
    //     }
    // };
    // Fonction pour gérer la recherche dans App1
    const handleSearch = (query) => {
        console.log("Requête de recherche dans App1 :", query);
        // Vous pouvez ajouter ici un filtre pour affiner les résultats selon la recherche
    };

    return (
        <div className="container">
            {/* Passez la fonction handleSearch en prop à SearchBar */}
            <SearchBar categories={categories} onSearch={handleSearch} />

{/* Liste des catégories avec liens */}
{/* <ul className="list-group mt-3"> */}
        {/* {categories.map((categorie) => (
          <li key={categorie.id} className="list-group-item">
            <Link to={`/produits/${categorie.id}`} className="text-decoration-none">
              {categorie.libelle_categorie}
            </Link>
          </li>
        ))} */}

                {/* {query &&
          filteredCategories.map((categorie) => ( 
            <li key={categorie.id} className="list-group-item">
              {categorie.libelle_categorie}
            </li>
          ))}  */}

      {/* </ul>         */}
      </div>
    );
};

export default App1;
