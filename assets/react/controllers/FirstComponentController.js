import { Controller } from '@hotwired/stimulus';
import React from 'react';
import { createRoot } from 'react-dom/client';
import FirstComponent from '../components/FirstComponent';

// export default class FirstComponentController extends Controller {
//     connect() {
        // console.log("FirstComponentController connected"); // Vérifier si ce message apparaît dans la console
        // this.element.innerHTML = "<p>Hello from FirstComponentController!</p>";
    //     const produits = JSON.parse(this.element.dataset.produits);
    //     console.log("Produits reçus :", products); // Vérification
    //     const root = createRoot(this.element);
    //     root.render(<FirstComponent produits={produits}/>);
    // }

    export default function (props) {
        return <div>Hello {props.fullName}</div>;
    
    
}
