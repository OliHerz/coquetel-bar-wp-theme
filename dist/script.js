// Sélectionnez tous les boutons avec la classe "button"
const buttons = document.querySelectorAll(".buttonToggle");

// Sélectionnez tous les articles avec la classe "article"
const articles = document.querySelectorAll(".articleContent");

document.getElementsByClassName(".articleContent")

// Boucle sur chaque bouton avec un forEach
buttons.forEach((button, index) => {

// Ajouter un écouteur d'événement "click" à chaque bouton
  button.addEventListener("click", () => {

    // Boucle sur chaque article et tous les masquer
    articles.forEach(article => {
      article.style.display = "none";
    });

    // Supprimez la classe 'active' de tous les boutons
    buttons.forEach(bouton => {
      bouton.classList.remove("active");
    });

    // Ajouter la classe 'active' au bouton qui a été cliqué
    button.classList.add("active");

// Afficher l'article lié au bouton qui a été cliqué
    if (articles[index].style.display === "none") {
      articles[index].style.display = "flex";
    }
  });

});

// NAVBAR HAMBURGER SCRIPT 

//  Aside class pour masquer et affcher la partie aside du site internet 
const asideClass = document.querySelector('.asideClass');
const hamburger = document.querySelector('.hamburger');
const navList = document.querySelector('.navList');
const navBar = document.querySelector('.nav');
const span = document.querySelector('span');

hamburger.addEventListener('click', function (){
  hamburger.classList.toggle('is-active');
  span.classList.toggle('is-active');
  articles.forEach(article => {
    article.style.display = "none";
  });
  buttons.forEach(b => {
    b.classList.remove("active");
  });
  navList.classList.toggle('navList-active');
  if (asideClass.style.display == "grid"){
    asideClass.style.display = "none";
  } else {
    asideClass.style.display = "grid";
  };
  if (navBar.style.display == "flex"){
    navBar.style.display = "none"
  } else {
    navBar.style.display = "flex"
  };

});