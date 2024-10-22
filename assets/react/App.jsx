// import React from 'react';
// import FilterComponent from './FilterComponent';

// const App = () => {
//     return (
//         <div>
//             <h1>Bienvenue dans mon Application React !</h1>
//             {/* Ajoutez vos autres composants ici */}
//         </div>
//     );
// };

// export default App;

// test

import React, { useState, useEffect } from 'react';
import FilterComponent from './components/FilterComponent';
import ProduitList from './components/ProduitList'; // Assure-toi d'avoir ce composant

const App = () => {
    const [produits, setProduits] = useState([]);
    const [produitsFiltres, setProduitsFiltres] = useState([]);
    const [searchTerm, setSearchTerm] = useState(''); // État pour le terme de recherche

    useEffect(() => {
        // Remplace cette URL par celle de ton API qui retourne les produits
        fetch('/api/produits')
            .then(response => response.json())
            .then(data => {
                setProduits(data);
                setProduitsFiltres(data); // Initialiser les produits filtrés avec tous les produits
            });
    }, []);

    const handleFilterChange = (categorie, gammeDePrix) => {
        let nouveauxProduitsFiltres = produits;

        // Filtrer par catégorie
        if (categorie) {
            nouveauxProduitsFiltres = nouveauxProduitsFiltres.filter(produit => produit.categorie === categorie);
        }

        // Filtrer par prix
        if (gammeDePrix) {
            const [minPrix, maxPrix] = gammeDePrix.split('-').map(Number);
            nouveauxProduitsFiltres = nouveauxProduitsFiltres.filter(produit => {
                if (maxPrix) {
                    return produit.prix >= minPrix && produit.prix <= maxPrix;
                }
                return produit.prix >= minPrix; // Plus de maxPrix
            });
        }

        setProduitsFiltres(nouveauxProduitsFiltres);
    };

    const handleSearch = (e) => {
        e.preventDefault(); // Empêche le rechargement de la page
        // Filtrer les produits en fonction du terme de recherche
        const produitsFiltres = produits.filter(produit =>
            produit.libelleProduit.toLowerCase().includes(searchTerm.toLowerCase())
        );
        setProduitsFiltres(produitsFiltres);
    };

    return (
        <div>
            <h1>Bienvenue dans mon Application React !</h1>
            <FilterComponent
                onFilterChange={handleFilterChange}
                searchTerm={searchTerm} 
                setSearchTerm={setSearchTerm} 
                handleSearch={handleSearch} 
                />
            <ProduitList produits={produitsFiltres} />
        </div>
    );
};

export default App;
