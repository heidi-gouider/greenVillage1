import React, { useState } from "react";
// import { Link } from "react-router-dom";
import { BrowserRouter as Router, Route, Routes, Link } from 'react-router-dom';

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
    // <Router>
    <div>
    <form onSubmit={handleSubmit}
    //  style={{ display: 'flex', alignItems: 'center' }}
     >
      <input
        type="text"
        style={{
        //   backgroundColor: "black",
          backgroundColor: "white",
          color: "black",
          // padding: "10px 40px 10px 20px",
          borderRadius: "5px",
          // width: "5vh",
          width: "200px",
        //   border: "none",
        }}
        value={query}
        onChange={handleSearch}
        placeholder="Recherche"
        className="form-control"
      />

{/* <i className="bi bi-search"></i> */}

<button 
                type="submit" 
                style={{ 
                    background: "transparent", 
                    border: "none", 
                    cursor: "pointer", 
                    // marginLeft: "-40px" // Ajustez pour qu'il soit collé à l'input
                }}
                aria-label="Rechercher"
                
            >
                {/* <i className="fa fa-search" aria-hidden="true" style={{ fontSize: "20px" }}></i> */}
                <i className="bi bi-search"></i>
            </button>
        </form>

      <ul className="list-group mt-3">
        {/* Si `query` est présent mais qu'il n'y a pas de résultats, afficher un message  */}
        {query && filteredCategories.length === 0 ? (
          <li className="list-group-item">Aucune catégorie trouvée</li>
        ) : null}


         {/* Si `query` est non vide, afficher les résultats filtrés  */}
        {query &&
          filteredCategories.map((categorie) => ( 
            <li key={categorie.id} className="list-group-item">
            {/* <Link to={`/produits/${categorie.id}`} className="text-decoration-none"> */}
              {categorie.libelle_categorie}
              {/* </Link> */}
            </li>
          ))}
          
      </ul>
      </div>
  );
};

export default SearchBar;
