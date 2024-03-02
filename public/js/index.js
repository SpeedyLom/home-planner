"use strict";
function greeter(person) {
    return "Hello, " + person;
}
let user = "SpeedyLom";
const hello = document.getElementById('hello');
if (hello !== null) {
    hello.textContent = greeter(user);
}
