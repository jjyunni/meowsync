function bleh() {
    return fetch('https://api.spoonacular.com/recipes/complexSearch?query=ramen&number=8&addRecipeInformation=true&apiKey=235b4b08e6d24993ae14df441896f107')
        .then((response) => response.json())
}

//fonction asynchrone
async function displaycooking() {
    const data = await bleh(); //getting data from library
    const container = document.getElementById("more"); //getting id of div to put in the content
    container.innerHTML = ""; //clearing the div
    data.results.forEach(recipe => { // loop to get each result
        const recipeCard = `
            <div class="fsection">
                <div class="card" data-cuisine="${recipe.cuisines}">
                    <div class="ftitle">
                        <h4>${recipe.title}</h4>
                        <button class="favorite-btn" data-id="${recipe.id}">♡</button>
                    </div>
                    <img class="foodpics-image" src="${recipe.image}" alt="${recipe.title}">
                    <p>Difficulty: ??? </p>
                    <p>Servings: ${recipe.servings}</p>
                    <p>Total time: ${recipe.readyInMinutes} mins</p>
                    <div class="times">
                        <p>prep: ???</p>
                        <p>cook: ???</p>
                        <p>rest: ???</p>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += recipeCard;
    });
}


//load when page loads
document.addEventListener("DOMContentLoaded", () => {
    displaycooking();
});




