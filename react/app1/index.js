// librairie React
import React from 'react'
import ReactDOM from 'react-dom/client'
import App1 from './app.jsx';
import SearchBar from '../components/searchBarComponent.jsx';

// app2 et searchBar sont montés conditionnellement sur leurs éléments DOM respectifs afin de ne pas causer de conflits ou erreurs si l'élément n'existe pas.

// const app2Root = document.getElementById('app2-root');
// if (app2Root) {
//     ReactDOM.createRoot(app2Root).render(
//     <React.StrictMode>
//         <App2 />
//     </React.StrictMode>
// );
// }

// const searchComponentRoot = document.getElementById('search-component-root');
// if (searchComponentRoot) {
//   ReactDOM.createRoot(document.getElementById('search-component-root')).render(
//     <React.StrictMode>
//       <SearchBar />
//     </React.StrictMode>
//   );
// }
const categories = []; // charger les catégories depuis l'API

// Créez votre application principale ici
ReactDOM.createRoot(document.getElementById('app1-root')).render(
    <React.StrictMode>
        <App1 categories={categories} /> {/* Passez les catégories ici si nécessaire */}
    </React.StrictMode>

);

// Rendre la barre de recherche
// ReactDOM.createRoot(document.getElementById('search-component-root')).render(
//     <React.StrictMode>
//         <SearchBar categories={categories} />
//     </React.StrictMode>
// );
