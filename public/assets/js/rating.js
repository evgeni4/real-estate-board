function add(ths, count) {
    for (let i = 1; i <= 5; i++) {
        const  elm = document.getElementById("star" + i)
        elm.className = "fal fa-star"
    }
    for (let i = 1; i <= count; i++) {
        const elm = document.getElementById("star" + i)
        if (elm.className === "fal fa-star") {
            elm.className = "fa fa-star checked"
        }
    }
}