const notes = Array.from(document.querySelectorAll('.avis'))
    .map(li => li.dataset.note);

console.log(notes);
