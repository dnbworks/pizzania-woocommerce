var ul = document.querySelector(".order-here ul");
var menu = document.querySelector(".menu-content");
var nav = document.querySelector("nav");
var lis = ul.querySelectorAll("li");
var pagination = document.querySelector(".pagination");
var contentWrappers = document.querySelectorAll(".content-wrapper");

// asynchronus function
const getMenu = async (url) => {
  const response = await fetch(url, {

  });

  const data = await response.json();
  console.log(data);
  return data;
};

lis.forEach((li) => {
  li.addEventListener("click", function (e) {
    e.preventDefault();
    var li_id = this.id;

    contentWrappers.forEach((wrapper) => {
      wrapper.classList.remove("show");
      wrapper.classList.add("none");
      if (wrapper.id === li_id) {
        wrapper.classList.add("show");
      }
    });

    // Start highlighting tabs
    lis.forEach((li) => {
      li.classList.remove("active");
    });
    this.classList.add("active");
    // End highlighting tabs

    // setting query params
    let type = this.id;
    const url = `/api?type=${type}`;

    // fetch data for clicked tab
    // getMenu(url)
    //   .then((data) => render(data, menu, type))
    //   .catch((err) => console.log("error", err));
  });
});

function render(data, element, type) {
  console.log("hi");

  var items = Array.from(element.querySelectorAll(".item"));
  var available;
  // console.log(data);
  // console.log(data.data.length);

  // pagination
  if (data.data.length > 6) {
  }

  if (data.data.length < 6) {
    available = data.data.length;
  } else {
    available = 6;
  }

  items.forEach((item) => {
    item.style.display = "none";
  });

  data.data.forEach((product, i) => {
    var dispalyItems = items.slice(0, available);

    dispalyItems.forEach((item, index) => {
      item.style.display = "block";
      if (index == i) {
        (item.querySelector(
          ".field-content a"
        ).href = `/order?type=${product.category}&name=${product.title}`),
          (item.querySelector(".views-field-price__number span").textContent =
            "PHP " + product.price),
          (item.querySelector(".product-list-title a").textContent =
            product.title),
          (item.querySelector(
            ".product-list-title a"
          ).href = `meal.html?type=${type}&pizza_id=1&pizza_name=${product.title}`),
          (item.querySelector(
            ".media img.media__image"
          ).src = `/asset/img/${product.img}`),
          (item.querySelector(".views-field-body p").textContent =
            product.description.slice(0, 50));
      }
    });
  });

  imgs.forEach((img) => {
    img.onload = function () {
      this.previousElementSibling.style.visibility = "hidden";
    };
  });

  pagination.innerHTML = data.pagination_links;
  if (pagination.querySelectorAll("a")) {
    let pagination_links = pagination.querySelectorAll("a");
    pagination_links.forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        let url = e.target.href;

        getMenu(url)
          .then((data) => render(data, menu, type))
          .catch((err) => console.log("error", err));
        // console.log(url);
      });
    });
  }
}

// var add_to_cart_btn = document.querySelector(".add_to_cart");
// var customize = document.querySelector(".customize");

// add_to_cart_btn.addEventListener("click", function (e) {
//   e.preventDefault();

//   let formSelected = e.currentTarget.parentElement;
//   let product_id = document.getElementById(formSelected.id + "-hidden").value;

//   let values = [];

//   values = Array.from(
//     document.querySelectorAll("input[type=checkbox]:checked")
//   ).map((item) => item.value);

//   values.forEach((variation_id) => {
//     $.ajax({
//       // Pass the admin-ajax.php into url.
//       url: ajax_object.ajax_url,
//       data: {
//         action: "techiepress_food_ajax_add_to_cart",
//         product_id: product_id,
//         variation_id: variation_id,
//       },
//       type: "post",
//       success: function (res) {
//         console.log(res);
//       },
//       error: function (err) {
//         console.log(err);
//       },
//     });
//   });

//   formSelected.reset();
// });


// ajax to clear cart
// ajax to remove single item
// ajax to edit the cart

var cartBtn = document.querySelector('.cartBtn-div');
var close_cart_btn = document.querySelector("#close-cart");
var cart = document.querySelector('.cart');
var items = document.querySelectorAll('.item');
var selected_item_modal = document.querySelector(".select-item-modal");
var close_modal_btn = document.querySelector('.close-modal-btn');
var customize_btn = document.querySelector('#customize-btn');
var customizeDiv = document.querySelector('.customize');
var options_header = document.querySelector('.options-header');

cartBtn.addEventListener('click', function(){
  cart.classList.add('show');
});

close_cart_btn.addEventListener('click', function(){
  cart.classList.remove('show');
});

items.forEach((item) => {
  item.addEventListener('click', function(e){
    // console.log(e.currentTarget.id);
    selected_item_modal.classList.add('show');
  })
})

close_modal_btn.addEventListener('click', function(){
  selected_item_modal.classList.remove('show');
});

customize_btn.addEventListener('click', function(e){
  e.preventDefault();
  console.log('click');
  customizeDiv.classList.add('show');
  options_header.classList.add('none');
});
