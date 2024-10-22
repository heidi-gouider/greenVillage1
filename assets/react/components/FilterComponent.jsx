import React, { useState } from 'react';

const FilterComponent = ({ onFilterChange }) => {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedCategory, setSelectedCategory] = useState('');
    const [priceRange, setPriceRange] = useState('');

    const handleCategoryChange = (e) => {
        setSelectedCategory(e.target.value);
        onFilterChange(e.target.value, priceRange);
    };

    const handlePriceChange = (e) => {
        setPriceRange(e.target.value);
        onFilterChange(selectedCategory, e.target.value);
    };

    const handleSearch = (e) => {
        e.preventDefault();
        // Rediriger vers la page de résultats avec le terme de recherche
        window.location.href = `/recherche?q=${encodeURIComponent(searchTerm)}`;
    };

    return (
        <div>
            <form onSubmit={handleSearch}>
            <input
                type="search"
                placeholder="recherche"
                aria-label="Search"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
            />
            <button type="submit">Recherche</button>
            {/* Tu peux ajouter d'autres filtres ici */}
        </form>
            <h3>Filtrer par catégorie</h3>
            <select onChange={handleCategoryChange}>
                <option value="">Toutes les catégories</option>
                {/* Remplacez ces options par vos catégories dynamiquement */}
                <option value="Les guitares">Guitares</option>
                <option value="les pianos">Pianos</option>
                <option value="les batteries">Batteries</option>
            </select>

            <h3>Filtrer par prix</h3>
            <select onChange={handlePriceChange}>
                <option value="">Tous les prix</option>
                <option value="0-50">0 à 50€</option>
                <option value="50-100">50 à 100€</option>
                <option value="100+">Plus de 100€</option>
            </select>
        </div>
    );
};

export default FilterComponent;
