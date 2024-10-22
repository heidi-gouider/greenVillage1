import React from 'react';
import FilterComponent from './FilterComponent';


// const FirstComponent = () => {
    export default function (props) {
            return <div>Hello {props.fullname}</div>;
    }

// test base


// import React, { useEffect, useState } from 'react';
// import axios from 'axios';

// const FirstComponent = () => {
//     const [data, setData] = useState(null);

//     useEffect(() => {
//         console.log("Fetching data...");
//         // Remplacez l'URL par votre point de terminaison API
//         axios.get('/api/${index}.json') // Assurez-vous que cette URL est correcte
//             .then(response => {
//                 setData(response.data);
//             })
//             .catch(error => {
//                 console.error("Erreur lors de la récupération des données:", error);
//             });
//     }, []); // Le tableau vide signifie que l'effet s'exécute une fois au montage

//     return (
//         <div>
//             <h1>Hello from React!</h1>
//             {data ? (
//                 <div>{JSON.stringify(data)}</div> // Affichez vos données ici
//             ) : (
//                 <p>Chargement...</p>
//             )}
//         </div>
//     );
// };

            // test produits
//         const FirstComponent = (props) => {
//             const { produits } = props; // Déstructuration des props
//     return (
//         <div>
//             <h1>Liste des Produits</h1>
//             <ul>
//                 {products.map(produit => (
//                     <li key={produit.id}>{produit.libelleProduit}</li>
//                 ))}
//             </ul>
//         </div>
//     );
// };

// export default FirstComponent;





// Test

// assets/react/components/FirstComponent.jsx
// import axios from "axios";
// import React, { useEffect, useState } from "react";

// const FirstComponent = () => {
//     const [data, setData] = useState(null);

//     useEffect(() => {
//         // Remplacez l'URL par votre point de terminaison API
//         axios.get('/api/endpoint')
//             .then(response => {
//                 setData(response.data);
//             })
//             .catch(error => {
//                 console.error("Erreur lors de la récupération des données:", error);
//             });
//     }, []); // Le tableau vide signifie que l'effet s'exécute une fois au montage

//     return (
//         <div>
//             <h1>Hello from React!</h1>
//             {data ? (
//                 <div>{JSON.stringify(data)}</div> // Affichez vos données ici
//             ) : (
//                 <p>Chargement...</p>
//             )}
//         </div>
//     );
// };

// export default FirstComponent;
