<?php
require_once("header.php");

if ($_POST) {
  if (isset($_POST["update"])) { // if i clicked on the submit for updating the recipe
    $idrecipe = $_POST["idrecipe"];
    $name = $_POST["name"];
    $cuisine = $_POST["cuisine"];
    $servings = $_POST["servings"];
    $time = $_POST["time"];

    try {
      $stmt = $pdo->prepare("UPDATE recipeCard SET name = :name, cuisine = :cuisine, servings = :servings, time = :time WHERE idrecipe = :idrecipe"); //updates the db recipeCard and set the submitted form as the new values.
      $stmt->execute([
        "name" => $name,
        "cuisine" => $cuisine,
        "servings" => $servings,
        "time" => $time,
        "idrecipe" => $idrecipe
      ]);
      header("Location: recipes.php"); //head back to the recipe.php
      exit();
    } catch (PDOException $e) { //for errors
      echo $e->getMessage();
    }
  } else { //if i clicked on the create recipe button cuz the form doesnt have a name
    $name = $_POST["name"];
    $cuisine = $_POST["cuisine"];
    $servings = $_POST["servings"];
    $time = $_POST["time"];

    try {
      $stmt = $pdo->prepare("INSERT INTO recipeCard (name, cuisine, servings, time) 
        VALUES(:name, :cuisine, :servings, :time)");
      $stmt->execute([ //insert the values on the form into the db
        "name" => $name,
        "cuisine" => $cuisine,
        "servings" => $servings,
        "time" => $time,
      ]);
      header("Location: recipes.php"); //send me back to the og page w the new data loaded
      exit();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}

$recipeToDelete = null; //empty so far

if (isset($_GET['action']) && $_GET['action'] === 'confirmdelete' && isset($_GET['idrecipe'])) {
  $recipeToDelete = $_GET['idrecipe'];
} //gets the primary key of the recipe we want to delete when the button is pressed

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

  $idrecipe = $_GET['idrecipe'];

  try {
    $stmt = $pdo->prepare("DELETE FROM recipeCard WHERE idrecipe = :idrecipe");

    $stmt->execute([
      "idrecipe" => $idrecipe,
    ]); //if the delete button is pressed when it asks for confirmation it gets deleted
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

$recipeToEdit = null; //same thing here

if (isset($_GET['action']) && $_GET['action'] == 'edit') {

  $idrecipe = $_GET['idrecipe']; //gets primary key of which recipe to edit

  try {
    $stmt = $pdo->prepare("SELECT * FROM recipeCard WHERE idrecipe = :idrecipe"); //select all values w that PK


    $stmt->execute([
      "idrecipe" => $idrecipe,
    ]);

    $recipeToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}


if (isset($_GET['filter']) && $_GET['filter'] == 'sortcollege') {
  // Filter: only recipes with 1 serving and sort alphabetically
  $stmt = $pdo->query("SELECT * FROM recipeCard WHERE servings = 1 AND time <= 30 ORDER BY name ASC");
} else {
  // Default: show all recipes
  $stmt = $pdo->query("SELECT * FROM recipeCard");
}

$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="main">
  <div class="cuisine-filters">
    <button class="cuisine-btn" data-cuisine="korean">🇰🇷 Korean</button>
    <button class="cuisine-btn" data-cuisine="chinese">🇨🇳 Chinese</button>
    <button class="cuisine-btn" data-cuisine="japanese">🇯🇵 Japanese</button>
    <button id="reset-filter">Reset</button>
    <form method="GET">
      <button type="submit" name="filter" value="sortcollege">
        Sort for college friendly recipes
      </button>
      <!-- button for php filter -->
    </form>
  </div>
  <div class="formcontent">
    <form method="POST" class="homeform">

      <label for="name">Name</label>
      <input type="text" name="name" id="name" placeholder="Name of the Dish">

      <label for="cuisine">Cuisine</label>
      <input type="text" name="cuisine" id="cuisine" placeholder="Cuisine">

      <label for="servings">Servings</label>
      <input type="number" name="servings" id="servings">

      <label for="time">Time</label>
      <input type="number" name="time" id="time">

      <input type="submit" value="Create Recipe">

    </form>
  </div>
  <!-- form to create recipe -->

  <?php foreach ($recipes as $key => $recipeCard): ?>
    <!-- for each row of values write them into the html same format as the other cards -->
    <div class="fsection">

      <div class="card" data-cuisine="<?php echo strtolower(htmlspecialchars($recipeCard['cuisine'])); ?>">
        <div class="ftitle">
          <h4><?php echo htmlspecialchars($recipeCard['name']); ?></h4>
          <button class="favorite-btn" data-id="<?php echo htmlspecialchars($recipeCard['idrecipe']); ?>">♡</button>
        </div>

        <img class="foodpics-image" src="content/biangbiang.jpg" alt="<?php echo htmlspecialchars($recipeCard['name']); ?>">

        <p>Cuisine: <?php echo htmlspecialchars($recipeCard['cuisine']); ?></p>
        <p>Servings: <?php echo htmlspecialchars($recipeCard['servings']); ?></p>
        <p>Total time: <?php echo htmlspecialchars($recipeCard['time']); ?></p>
        <div class="times">
          <a href="?idrecipe=<?php echo urlencode($recipeCard['idrecipe']); ?>&action=confirmdelete">Delete</a>
          <!-- button to bring to confirm delete and add to url -->
          <a href="?idrecipe=<?php echo urlencode($recipeCard['idrecipe']); ?>&action=edit">Edit</a>
          <!-- same here but for edit -->

        </div>

      </div>
    </div>
  <?php endforeach; ?>

  <div class="fsection">
    <div class="card" data-cuisine="chinese">
      <div class="ftitle">
        <h4>Biang Biang Noodle</h4>
        <button class="favorite-btn" data-id="biangbiang">♡</button>
      </div>
      <img class="foodpics-image" src="content/biangbiang.jpg" alt="biangbiang">
      <ul>
        <li>Cuisine: Chinese</li>
        <li>Servings: 1</li>
        <li>Total time: 1h40</li>
      </ul>
      <div class="times">
        <p>Total time: 1h40</p>
      </div>
    </div>
    <div class="recipe">
      <div class="ingredients">
        <h1>Ingredients</h1>
        <ul>
          <li> • 1 tablespoon scallions - finely chopped</li>
          <li> • 2 teaspoon garlic - minced</li>
          <li> • Chili flakes - to taste</li>
          <li> • Chili powder - to taste</li>
          <li> • ¼ teaspoon ground Sichuan pepper</li>
          <li> • Salt - to taste</li>
          <li> • 3 tablespoon cooking oil</li>
          <li> • 1 tablespoon light soy sauce</li>
          <li> • 1 tablespoon black rice vinegar</li>
        </ul>
      </div>
      <div class="instructions">
        <h1>Instructions</h1>
        <p> • Place the noodle into the boiling water.</p>
        <p> • When the noodles are nearly cooked through, add bok choy and blanch for 20 seconds.</p>
        <p> • Season the noodles</p>
        <p> • Put the drained noodles and blanched bok choy into 2 serving plates or bowls. Top them with chopped
          scallions, minced garlic, chili flakes, chili powder, ground Sichuan pepper, and salt.</p>
        <p> • Heat up the oil in a small pan. When it starts to smoke, pour it over the aromatics and spices to
          sizzle. Add light soy sauce and black rice vinegar. Stir to coat the noodles evenly.</p>
      </div>
    </div>
  </div>
  <div class="fsection">
    <div class="card" data-cuisine="korean">
      <div class="ftitle">
        <h4>Cabbage Dup Bap</h4>
        <button class="favorite-btn" data-id="cdupbap">♡</button>
      </div>
      <img class="foodpics-image" src="content/dupbap.jpg" alt="dupbap">
      <p>Difficulty: ★★★</p>
      <p>Servings: 6</p>
      <p>Total time: 1h15</p>
      <div class="times">
        <p>prep: 15mins</p>
        <p>cook: 1h</p>
        <p>rest: 0</p>
      </div>
    </div>
    <div class="recipe">
      <div class="ingredients">
        <h1>Ingredients</h1>
        <p> • 6 slices bacon, chopped</p>
        <p> • 1 large onion, diced</p>
        <p> • 2 cloves garlic, minced</p>
        <p> • 1 large head cabbage, cored and sliced</p>
        <p> • 1 tablespoon salt, or to taste</p>
        <p> • 1 teaspoon ground black pepper</p>
        <p> • ½ teaspoon onion powder</p>
        <p> • ½ teaspoon garlic powder</p>
        <p> • ⅛ teaspoon paprika</p>
      </div>
      <div class="instructions">
        <h1>Instructions</h1>
        <p> • Place bacon in a large stockpot and cook over medium-high heat until crispy, about 10 minutes.</p>
        <p> • Add onion and garlic; cook and stir until onion caramelizes, about 10 minutes.</p>
        <p> • Immediately stir in cabbage and continue to cook and stir another 10 minutes.</p>
        <p> • Season with salt, pepper, onion powder, garlic powder, and paprika. Reduce heat to low, cover, and
          simmer, stirring occasionally, about 30 minutes more.</p>
      </div>
    </div>
  </div>
  <div class="fsection">
    <div class="card" data-cuisine="japanese">
      <div class="ftitle">
        <h4>Japanese Curry</h4>
        <button class="favorite-btn" data-id="jpncurry">♡</button>
      </div>
      <img class="foodpics-image" src="content/jpncurry.jpg" alt="jpncurry">
      <p>Difficulty: ★☆☆</p>
      <p>Servings: 1</p>
      <p>Total time: 20mins</p>
      <div class="times">
        <p>prep: 10mins</p>
        <p>cook: 10mins</p>
        <p>rest: 0</p>
      </div>
    </div>
    <div class="recipe">
      <div class="ingredients">
        <h1>Ingredients</h1>
        <p> • 1 block curry cube, roughly chopped</p>
        <p> • 150 to 180 ml water</p>
        <p> • vegetables of choice</p>
        <p> • protein of choice</p>
        <p> • salt and pepper, to taste</p>
        <p> • rice, for serving</p>
        <p> • 1 (5 g) tsp butter or oil</p>
        <p> • 1/4 (65 g) onion, sliced</p>
        <p> • 1 oz carrot, chopped small</p>
        <p> • 1 small (60 g) potato, diced into 3/4 inch chunks</p>
        <p> • 1/2 (20 g) cup soy curls, rehydrated(or 50 g of thinly sliced beef, pork or chicken)</p>
        <p></p>
      </div>
      <div class="instructions">
        <h1>Instructions</h1>
        <p> • Over medium high heat, add oil or butter and cook onion for a few minutes until lightly caramelized
          (this takes about 3 minutes).</p>
        <p> • Add carrots and potato and grated apples, and cook for about 2 minutes. Add soy curls, salt, pepper and
          cayenne. If using another protein, cook until no longer pink. ‘</p>
        <p> • Add water and bring to a boil. Then reduce heat and simmer for 8 minutes until potatoes are tender.</p>
        <p> • Simmer for 2 minutes. </p>
      </div>
    </div>
  </div>
  <div id="more"></div>
</section>


<!-- pop up modal for the edit w same css from the first modal i made in the footer -->
<?php if ($recipeToEdit): ?> 
  <!-- if var not null run code -->
  <div class="modal" id="editRecipeModal" style="display: flex;">
    <!-- flex centers the pop up -->
    <div class="modal-content">
      <h2>Edit Recipe</h2>
      <form method="POST" class="modalform">
        <input type="hidden" name="idrecipe" value="<?php echo htmlspecialchars($recipeToEdit['idrecipe']); ?>">

        <!-- prefill the form with what it already had -->

        <label>Name of the Dish</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($recipeToEdit['name']); ?>">

        <label>Cuisine</label>
        <input type="text" name="cuisine" value="<?php echo htmlspecialchars($recipeToEdit['cuisine']); ?>">

        <label>Servings</label>
        <input type="number" name="servings" value="<?php echo htmlspecialchars($recipeToEdit['servings']); ?>">

        <label>Time</label>
        <input type="number" name="time" value="<?php echo htmlspecialchars($recipeToEdit['time']); ?>">

        <button type="submit" name="update">Update</button>
      </form>
    </div>
  </div>
<?php endif; ?>


<?php if ($recipeToDelete): ?> 
  <div class="modal" id="deleteModal" style="display: flex;">
    <div class="modal-content">
      <h2>Confirm Deletion</h2>
      <p>Are you sure you want to delete this recipe?</p>
      <div class="yesorno">
        <a class="modalbtn delete-confirm" href="?idrecipe=<?php echo $recipeToDelete; ?>&action=delete">Delete</a>
        <a class="modalbtn cancel-confirm" href="recipes.php">Cancel</a>
      </div>
    </div>
  </div>
<?php endif; ?>




<script src="cooking.js"></script>



<?php
require_once("footer.php");
?>