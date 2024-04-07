
/**
 * Function to cause an object to rotate colours in a provided series.
 * @param {list} colours The list of colours to rotate between.
 * @param {id} text The HMTL id of the object to be mutated.
 */
function crazyText (colours, text) {
    setInterval(function rotatecolours () {
        for (let i = Object.keys(colours).length; i >= 0; i--) {
            if (text.classList.contains(colours[i])) {
                text.classList.add(colours[i + 1]);
                text.classList.remove(colours[i]);
            }
        }
        if (text.classList.contains(colours[-1])) {
        text.classList.remove(colours[-1]);
        text.classList.add(colours[0]);
        }
    }, 250);
    setInterval(function resize() {
        if (text.classList.contains("large")) {
            text.classList.add("small");
            text.classList.remove("large");
        } else {
            text.classList.add("large");
            text.classList.remove("small");
        }
    }, 2000)
}

export { crazyText }