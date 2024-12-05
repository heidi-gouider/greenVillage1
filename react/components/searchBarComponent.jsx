import React, { useState } from "react";
// import { Link } from "react-router-dom";
// import { BrowserRouter as Router, Route, Routes, Link } from 'react-router-dom';

const SearchBar = ({ categories = [], onSearch }) => {

  // Stocke la valeur de recherche de l'utilisateur.
  const [query, setQuery] = useState("");
  // contient les categories correspondant à la requête de recherche.
  const [filteredCategories, setFilteredCategories] = useState([]);

  // Fonction utilitaire pour nettoyer les chaînes en supprimant les déterminants
  // const removeDeterminants = (str) => {
  //     const determinants = ['le', 'la', 'les', 'un', 'une', 'des', 'l\''];
  //     const regex = new RegExp(`^(${determinants.join('|')})\\s+`, 'i');
  //     return str.replace(regex, '').trim();
  // };

  // Fonction de mise à jour de la recherche
  const handleSearch = (e) => {
    const searchQuery = e.target.value.toLowerCase();
    setQuery(searchQuery);

    // Filtrage des categories en fonction de la recherche
    const results = categories.filter((categorie) =>
      // Au lieu d'utiliser includes, utiliser startsWith pour prendre la premiere lettre tapée
      categorie.libelle_categorie.toLowerCase().startsWith(searchQuery)
    );

    setFilteredCategories(results);
    // Vérification du résultat de la recherche dans la console
    console.log("Résultat de recherche :", results);
  };

  // Fonction appelée lors du clic sur l'icône de recherche
  const handleSubmit = (e) => {
    e.preventDefault();
    if (query.trim()) {
      // Si la requête de recherche n'est pas vide, on appelle la fonction onSearch
      onSearch(query);
    }
  };

  return (
    <>
      {/* Conteneur avec flexbox pour centrer */}
    <div style={{
      display: 'flex',
      justifyContent: 'center',  // Centrer horizontalement
      alignItems: 'center',      // Centrer verticalement
      // height: '100vh'             // Prendre toute la hauteur de la fenêtre
    }}>
        <form onSubmit={handleSubmit} style={{ position: "relative", width: "250px" }}>
          {/* <div style={{ display: "flex", justifyContent: "center", alignItems: "center" }}> */}

          {/* Input avec un bouton intégré */}
          <div style={{ position: "relative", boxshadow: "0 15px 40px rgba(0, 0, 0, 0.8)"
 }}>
            <input
              type="text"
              style={{
                //   backgroundColor: "black",
                backgroundColor: "white",
                color: "black",
                padding: "10px 40px 10px 10px",
                borderRadius: "5px",
                // width: "5vh",
                width: "200px",
                // border: "none",
              }}
              value={query}
              onChange={handleSearch}
              placeholder="Recherche"
              className="form-control"
            />

            {/* Bouton de recherche positionné à l'intérieur de l'input */}
            <button
              type="submit"
              style={{
                position: "absolute",
                right: "10px",
                top: "50%",
                transform: "translateY(-50%)",
                background: "transparent",
                border: "none",
                cursor: "pointer",
              }}
              aria-label="Rechercher"
            >
              <i className="bi bi-search" aria-hidden="true" style={{ fontSize: "16px" }}></i>
            </button>
          </div>

        </form>
        </div>

        <ul className="list-group mt-3 text-center" style={{ display: "flex", justifyContent: "center", alignItems: "center" }}>
          {/* <ul className="dropdown-menu show" style={{ position: "absolute", width: "100%", zIndex: 1000 }}> */}

          {/* Si `query` est présent mais qu'il n'y a pas de résultats, afficher un message  */}
          {query && filteredCategories.length === 0 ? (
            <li className="list-group-item">Aucune catégorie trouvée</li>
          ) : null}


          {/* Si `query` est non vide, afficher les résultats filtrés  */}
          {query &&
            filteredCategories.map((categorie) => (
              <a key={categorie.id} 

                href={`https://127.0.0.1:8000/produits/${categorie.id}`}>
                {/* </a> */}
                {categorie.libelle_categorie}
              </a>
            ))}
        </ul>
      </>
      );
};

      export default SearchBar;
