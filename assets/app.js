//import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import '../src/colours.mjs'
import { crazyText } from '../src/colours.mjs';

const colours = require("./json/colours.json");
const text = document.getElementById("crazyText");
if (text != null) {
    crazyText(colours, text)
}

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
