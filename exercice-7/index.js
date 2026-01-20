export class ContentForm {
    #searchInput;
    #contentInput;
    #form;

    constructor() {
        this.#form = document.querySelector("#content-form");
        this.#searchInput = document.querySelector("#seo-search");
        this.#contentInput = document.querySelector("#content");
        // L'erreur est un problème de perte référencement du this selon le monteur de recherche
        this.#form.addEventListener("submit", (event) => this.#submit(event));
    }

    async #request(terms){
        const response = await ai.models.generateContent({
            model: "gemini-2.5-flash",
            contents: terms,
        });

        let modal = document.querySelector("div.modal");
        modal.style.display = "none";

        let section = document.querySelector("#gemini-answer");
        section.scrollIntoView();

        section.innerHTML = marked.parse(response.text);
    }

    #submit(event)
    {
        event.preventDefault();
        let modal = document.querySelector("div.modal");
        modal.style.display = "grid";
        let search = this.#searchInput.value;
        let content = this.#contentInput.value;

        let terms = `Bonjour, pourrais-tu me calculer un score SEO pour un contenu que je vais
        t'envoyer en format Markdown. Les termes de recherches pour lesquels calculer sont les suivants : ${search}.
        Le contenu est le suivant : ${content}. J'aurais besoin d'une réponse synthétique au format Markdown avec un score sur 20. Merci !`;

        this.#request(terms);
    }
}