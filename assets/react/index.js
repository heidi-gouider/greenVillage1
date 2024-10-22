import React from 'react'
import ReactDOM from 'react-dom/client'
// import MonPremierComposant from "./jsx/MonPremierComposant";
// import FirstComponent from "./FirstComponent.jsx";
import App from './App';
// import './index.css'

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