import React from 'react'
import ReactDOM from 'react-dom/client'
// import MonPremierComposant from "./jsx/MonPremierComposant";
// import FirstComponent from "./FirstComponent.jsx";

// composant principal & style
import App from './App.jsx';
// import App from './App';

// import './assets/styles/style.css'
// console.log("test app-react")
// chargement du composant App dans le dom
ReactDOM.createRoot(document.getElementById('root')).render(
    <React.StrictMode>
        {/* <FirstComponen /> */}
        <App />
    </React.StrictMode>,
)

// Notre composant principal et le style
// import App from './App.jsx'

// Nous chargeons le composant App dans le DOM 
// (dans l'élément qui porte l'id root)
// ReactDOM.createRoot(document.getElementById('root')).render(
//   <React.StrictMode>
//     <FirstComponent />
//   </React.StrictMode>,
// )