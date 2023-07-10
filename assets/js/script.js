var ul = document.querySelector(".order-here ul");
var menu = document.querySelector(".menu-content");
var nav = document.querySelector("nav");
var lis = ul.querySelectorAll("li");
var pagination = document.querySelector(".pagination");
var contentWrappers = document.querySelectorAll(".content-wrapper");
var imgs = document.querySelectorAll('.media img.media__image');

// asynchronus function
const getMenu = async (url) => {
  const response = await fetch(url, {});
  const data = await response.json();
  return data;
};

lis.forEach((li) => {
  li.addEventListener("click", function (e) {
    e.preventDefault();
    var li_id = this.id;
    console.log(this.id);

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
    const url = `http://pizza.local/wp-json/pizza/v1/product-category?term=${type}`;


    // fetch data for clicked tab
    getMenu(url)
      .then((data) => render(data, menu, type))
      .catch((err) => console.log("error", err));
  });
});

function render(data, element, type) {
  var dataArray = JSON.parse(data);

  var items = Array.from(element.querySelectorAll(".item"));

  items.forEach((item) => {
    item.style.display = "none";
  });

  dataArray.data.forEach((product, i) => {
    var dispalyItems = items.slice(0, 6);

    dispalyItems.forEach((item, index) => {
      item.style.display = "block";
      if (index == i) {
        console.log(product.product_price);
        item.querySelector(".views-field-price__number").innerHTML = product.product_price;
        item.querySelector(".product-list-title a").textContent = product.product_title;
        item.querySelector(".media img.media__image").src = product.product_thumbnail_url;
      }
    });
  });

  // imgs.forEach((img) => {
  //   img.onload = function () {
  //     this.previousElementSibling.style.visibility = "hidden";
  //   };
  // });


  
  if (dataArray.pagination) {
    pagination.innerHTML = dataArray.pagination;
  } else {
    pagination.innerHTML = "";
  }
  var paginate_links = document.querySelectorAll(".page-numbers");
  if (paginate_links.length) {
    paginate_links.forEach((link) => {
      link.addEventListener("click", function(e){
        e.preventDefault();
        console.log(e.currentTarget.href);
        getMenu(e.currentTarget.href)
        .then((data) => render(data, menu, type))
        .catch((err) => console.log("error", err));
      })
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

var cartBtn = document.querySelector(".cartBtn-div");
var close_cart_btn = document.querySelector("#close-cart");
var cart = document.querySelector(".cart");
var items = document.querySelectorAll(".item");
var selected_item_modal = document.querySelector(".select-item-modal");
var close_modal_btn = document.querySelector(".close-modal-btn");
var customize_btn = document.querySelector("#customize-btn");
var customizeDiv = document.querySelector(".customize");
var options_header = document.querySelector(".options-header");

var categories = JSON.parse(document.querySelector('#json-info').dataset.categories);



cartBtn.addEventListener("click", function () {
  cart.classList.add("show");
});

close_cart_btn.addEventListener("click", function () {
  cart.classList.remove("show");
});

items.forEach((item) => {
  item.addEventListener("click", function (e) {



    let cat_id = JSON.parse(e.currentTarget.dataset.product).product_categories.find((cat) => cat !== 22);
    let get_category = categories.find((category) => category.term_id == cat_id);

    selected_item_modal.querySelector(".dialog-item-details .pizza-name").innerHTML = JSON.parse(e.currentTarget.dataset.product).product_name;
    selected_item_modal.querySelector(".dialog-item-details .title").innerHTML = "MY " + get_category.name;
    selected_item_modal.querySelector(".dialog-item-details img").src = JSON.parse(e.currentTarget.dataset.product).product_image;
   
    selected_item_modal.dataset.attributes = e.currentTarget.dataset.attributes;
    selected_item_modal.classList.add("show");
    
    if (JSON.parse(e.currentTarget.dataset.attributes) !== false) {
      var keys = Object.keys(JSON.parse(e.currentTarget.dataset.attributes)).map((key) =>  {
        return key.slice(3, key.length);
      });

      console.log(JSON.parse(e.currentTarget.dataset.attributes));

      var label_input = '';

      
      // keys.forEach(key => {
      //   label_input = `
      //   <label for="size">Choose your ${get_category.name} ${key}</label>
      //   <div style="margin-bottom: 10px; position: relative;">
      //     <i class="fas fa-caret-down"></i>
      //     <input type="text" name="${key}" class="input-text input" placeholder="Choose your ${key}" data-listen="input" autocomplete="off" readonly="" id="size">
      //     <ul class="list" style="display: none;">
      //       <li data-select-value="${}" data-price-value="${attribute.type.selection.price}" data-product="${product.id}">
      //         <div class="o-form-dropdown_input--item">
      //           <h5 class="h5">${ key === "No Add-ons" ? '<i class="fas fa-ban"></i>' : ''} ${}</h5>
      //           <div class="o-form-dropdown_input--item__subdetail">
      //             <span>₱${}</span>
      //           </div>
      //         </div>
      //       </li>
      //     </ul>
      //   </div>`
      // });




      var customize_template = `
      <div class="customize">
        <div class="title">Select your options</div>
        <form action="#" method="post" id="form">
          
          <label for="Instruction">Special Instruction (optional)</label>
          <textarea name="Instruction" id="Instruction" class="input" placeholder="Add Special Instruction here"></textarea>
          <button type="submit" id="add"><img src="asset/img/loader.svg" alt="" srcset="">Add to Tray</button>
        </form>
        </div>
        `;

      // console.log(keys);
      // console.log(JSON.parse(e.currentTarget.dataset.attributes));
    }
  });
});

close_modal_btn.addEventListener("click", function () {
  selected_item_modal.classList.remove("show");
  options_header.classList.remove("none");
  customizeDiv.classList.remove("show");
});

customize_btn.addEventListener("click", function (e) {
  e.preventDefault();
  console.log("click");
  customizeDiv.classList.add("show");
  options_header.classList.add("none");
});

const input_texts = document.querySelectorAll(".input-text");
const form = document.querySelector("#form");


input_texts.forEach((input) => {
  input.addEventListener("focus", handleFocus);
  input.addEventListener("blur", handleBlur);
});

function handleFocus() {
  this.nextElementSibling.style.display = "block";
}

function handleBlur() {
  var input = this;

  this.nextElementSibling.querySelectorAll("li").forEach((li) => {
    li.addEventListener("click", function () {
      input.value = this.querySelector("h5").textContent;
      this.parentElement.style.display = "none";
    });
  });

  setTimeout(() => {
    this.nextElementSibling.style.display = "none";
  }, 100);
}

// jQuery.ajax({
//   url: WC_VARIATION_ADD_TO_CART.ajax_url,
//   data: {
//     action: "woocommerce_add_variation_to_cart",
//     product_id: "124",
//     variation_id: "125",
//     quantity: 1,
//     variation: {
//       size: "xl",
//       color: "pink",
//     },
//   },
//   type: "POST",
// });

