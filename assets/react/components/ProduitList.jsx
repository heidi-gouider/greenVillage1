import React from 'react';

const ProduitList = ({ produits }) => {
    return (
        <div>
            {produits.length === 0 ? (
                <p>Aucun produit trouvé.</p>
            ) : (
                <ul>
                    {produits.map(produit => (
                        <li key={produit.id}>
                            <h4>{produit.libelleProduit}</h4>
                            <p>Prix : {produit.prix}€</p>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
};

export default ProduitList;
