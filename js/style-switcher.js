/* ========================== toggle style switcher =========================== */
const styleSwitcherToggle = document.querySelector(".style-switcher-toggler");
styleSwitcherToggle.addEventListener("click", () => {
    document.querySelector(".style-switcher").classList.toggle("open");
})
// hide style - switcher on scroll
window.addEventListener("scroll", () => {
    if(document.querySelector(".style-switcher").classList.contains("open"))
    {
        document.querySelector(".style-switcher").classList.remove("open");
    }
})
/* ========================== theme colors =========================== */
const alternateStyles = document.querySelectorAll(".alternate-style");
function setActiveStyle(color)
{
    alternateStyles.forEach((style) => {
        if(color === style.getAttribute("title"))
        {
            style.removeAttribute("disabled");
        }
        else
        {
            style.setAttribute("disabled","true");
        }
    })
}
/* ========================== theme light and dark mode =========================== */
const dayNight = document.querySelector(".day-night");
dayNight.addEventListener("click", () => {
    dayNight.querySelector("i").classList.toggle("fa-sun");
    dayNight.querySelector("i").classList.toggle("fa-moon");
    document.body.classList.toggle("dark");
})
window.addEventListener("load", () => {
    if(document.body.classList.contains("dark"))
    {
        dayNight.querySelector("i").classList.add("fa-sun");
    }
    else
    {
        dayNight.querySelector("i").classList.add("fa-moon");
    }
})

/* ========================== translator =========================== */
// Langue actuelle (par défaut : français)
let currentLanguage = "fr";

// Fonction pour charger les traductions depuis un fichier JSON
async function loadTranslations(language) {
  const response = await fetch(`langues/${language}.json`);
  if (!response.ok) {
    throw new Error(`Erreur lors du chargement du fichier ${language}.json`);
  }
  return response.json();
}

// Fonction pour mettre à jour les textes et attributs dynamiquement
async function changeLanguage() {
  try {
    // Alterner entre le français et l'anglais
    currentLanguage = currentLanguage === "fr" ? "en" : "fr";

    // Charger les traductions correspondantes
    const translations = await loadTranslations(currentLanguage);

    // Parcourir toutes les clés de l'objet translations
    for (const id in translations) {
      const element = document.getElementById(id);
      if (!element) continue;

      const text = translations[id];

      // Si c'est un <input> ou <textarea> avec placeholder, on change l'attribut
      if (
        (element.tagName.toLowerCase() === "input" ||
         element.tagName.toLowerCase() === "textarea") &&
        element.hasAttribute("placeholder")
      ) {
        element.setAttribute("placeholder", text);
      }
      // Sinon, on met à jour le texte intérieur
      else {
        element.textContent = text;
      }
    }

    // Mettre à jour l'image du drapeau
    const translatorIcon = document.querySelector(".translator img");
    translatorIcon.src = currentLanguage === "fr"
      ? "images/flags/gb.png"
      : "images/flags/fr.png";
    translatorIcon.alt = currentLanguage === "fr"
      ? "English"
      : "Français";
  } catch (error) {
    console.error("Erreur lors du chargement des traductions :", error);
  }
}

// Ajouter un événement au clic sur l'icône de drapeau
document.addEventListener("DOMContentLoaded", () => {
  const FrEnIcon = document.querySelector(".fr-en");
  if (FrEnIcon) {
    FrEnIcon.addEventListener("click", changeLanguage);
  } else {
    console.error("L'élément avec la classe .fr-en est introuvable !");
  }
});
/* ========================== end of translator =========================== */