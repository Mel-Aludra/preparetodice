/* Delete current element */
function deleteCurrentElement(element) {
    element.parentNode.style.display = "none";
}

/* Burger menu (front) */
$("#frontBurgerMenu").on("click", function() {
    let menu = $("#frontMenuContainer");
    if(menu.hasClass("active")) {
        menu.removeClass("active");
    } else {
        menu.addClass("active");
    }
});

/* Burger menu (front) */
$("#gameFrontBurgerMenu").on("click", function() {
    let menu = $("#nav");
    if(menu.hasClass("active")) {
        menu.removeClass("active");
    } else {
        menu.addClass("active");
    }
});

/* Burger menu */
$("#burgerMenu").on("click", function() {
    let menu = $("#nav");
    if(menu.hasClass("active")) {
        menu.removeClass("active");
    } else {
        menu.addClass("active");
    }
});

/* Unfoldable objects  */
$(".unfoldable>.header").each(function() {
    $(this).on("click", function() {
        let elt = $(this).parent();
        if(elt.hasClass("unfold")) {
            elt.removeClass("unfold");
        } else {
            elt.addClass("unfold");
        }
    });
    $(this).find('a').on("click", function(e) {
        e.stopPropagation();
    });
});
function unfold(action) {
    let elt = action.parentNode;
    if(elt.classList.contains("unfold")) {
        elt.classList.remove("unfold");
    } else {
        elt.classList.add("unfold");
    }
}

/* Toggles container */
$(".togglesContainer>p").each(function() {
    $(this).on("click", function() {
        let data = this.getAttribute("data-toggle");
        let input = this.parentNode.getElementsByTagName("input")[0];
        input.value = data;
        let elts = this.parentNode.getElementsByTagName("p");
        for(let i = 0; i < elts.length; i++) {
            elts[i].classList.remove("active");
        }
        this.classList.add("active");
    })
});