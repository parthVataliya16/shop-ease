$(document).ready(function () {
  $.ajax({
    method: "GET",
    url: "/practice/Project/routes/web.php/v1/getProduct",
    success: function (result) {
      // console.log(result);
      if (result.response.status == 200) {
        productListing(result.products);
        new DataTable(".table", {
          columnDefs: [{ orderable: false, targets: [0, 7] }],
          order: [[0, "asc"]],
          scrollX: true,
        });
        const deleteButtons = document.querySelectorAll(".deleteButton");
        deleteButtons.forEach((button) => {
          button.addEventListener("click", () => {
            const id = button.getAttribute("id").slice(4);
            deleteProductPopup(id);
          });
        });

        const pagginationButton = document.querySelectorAll(".paginate_button");
        pagginationButton.forEach((button) => {
          button.addEventListener("click", () => {
            const deleteButtons = document.querySelectorAll(".deleteButton");
            deleteButtons.forEach((deletebtn) => {
                console.log(deletebtn);
                deletebtn.addEventListener("click", () => {
                const id = deletebtn.getAttribute("id").slice(4);
                deleteProductPopup(id);
              });
            });
          });
        });
      } else {
        document.querySelector(".products").innerHTML = result.response.message;
      }
    },
  });
});

const deleteProductPopup = (id) => {
  Swal.fire({
    title: "Are you sure to delete this product?",
    text: "You won't be able to retrive this product!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete!",
  }).then((result) => {
    if (result.isConfirmed) {
      deleteProduct(id);
      Swal.fire({
        title: "Deleted!",
        text: "product deleted successfully!",
        icon: "success",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.reload();
        }
      });
    }
  });
};

const productListing = (products) => {
  console.log(products);
  products.forEach((product) => {
    const row = document.createElement("tr");
    document.getElementsByClassName("products")[0].appendChild(row);
    row.classList.add("productData", "p-2");

    const rowNumber = document.getElementsByClassName("productData").length;

    for (const index in product) {
      if (index == "id" || index == "category_id") {
        continue;
      }
      const data = document.createElement("td");
      document
        .getElementsByClassName("productData")
        [rowNumber - 1].appendChild(data);
      data.classList.add(`${index}`);
      if (product[index] == null || product[index] == "") {
        data.innerHTML = "NA";
      } else {
        if (product[index].length > 40) {
          data.innerHTML = `${product[index].slice(0, 40)}...`;
        } else {
          data.innerHTML = product[index];
        }
      }
    }

    const actionOnproductData = document.createElement("td");
    document
      .getElementsByClassName("productData")
      [rowNumber - 1].appendChild(actionOnproductData);
    actionOnproductData.classList.add("actionOnproductData", "dropdown");

    const numberOfActionOnproductDataClass = document.getElementsByClassName(
      "actionOnproductData"
    ).length;
    const actionButton = document.createElement("button");
    document
      .getElementsByClassName("actionOnproductData")
      [numberOfActionOnproductDataClass - 1].appendChild(actionButton);
    actionButton.classList.add("actionButton");
    actionButton.innerHTML = "Action";

    const dropdownButtons = document.createElement("div");
    document
      .getElementsByClassName("actionOnproductData")
      [numberOfActionOnproductDataClass - 1].appendChild(dropdownButtons);
    dropdownButtons.classList.add("dropdownButtons");

    const numberOfDropdownButtons =
      document.getElementsByClassName("dropdownButtons").length;
    const deleteButton = document.createElement("button");
    document
      .getElementsByClassName("dropdownButtons")
      [numberOfDropdownButtons - 1].appendChild(deleteButton);
    deleteButton.classList.add("btn", "btn-danger", "deleteButton");
    deleteButton.setAttribute("id", `btn_${product.id}`);
    deleteButton.innerHTML = "Delete";

    const updateButton = document.createElement("button");
    document
      .getElementsByClassName("dropdownButtons")
      [numberOfDropdownButtons - 1].appendChild(updateButton);
    updateButton.classList.add("btn", "btn-primary", "updateButton");

    const numberOfUpdateButtonClass =
      document.getElementsByClassName("updateButton").length;
    const updateproduct = document.createElement("a");
    document
      .getElementsByClassName("updateButton")
      [numberOfUpdateButtonClass - 1].appendChild(updateproduct);
    updateproduct.classList.add("update", "text-decoration-none", "text-light");
    updateproduct.setAttribute("id", `update_${product.id}`);
    updateproduct.setAttribute("href", `updateProduct.php?id=${product.id}`);
    updateproduct.innerHTML = "Update";
    //
    // const deleteData = document.createElement("td");
    // document.getElementsByClassName("productData")[rowNumber - 1].appendChild(deleteData);
    // deleteData.classList.add("deleteData");

    // const deleteButtonNumber = document.getElementsByClassName("deleteData").length;
    // const deleteButton = document.createElement("button");
    // document.getElementsByClassName("deleteData")[deleteButtonNumber - 1].appendChild(deleteButton);
    // deleteButton.classList.add("btn", "btn-danger", "deleteButton");
    // deleteButton.setAttribute("id", `btn_${product.id}`)
    // deleteButton.innerHTML = "Delete";

    // const updateData = document.createElement("td");
    // document.getElementsByClassName("productData")[rowNumber - 1].appendChild(updateData);
    // updateData.classList.add("updateData")

    // const updateButtonNumber = document.getElementsByClassName("updateData").length;
    // const update = document.createElement("a");
    // document.getElementsByClassName("updateData")[updateButtonNumber - 1].appendChild(update);
    // update.classList.add("update");
    // update.setAttribute("href", `updateProduct.php?id=${product.id}`);

    // const updateButton = document.createElement("button");
    // document.getElementsByClassName("update")[updateButtonNumber - 1].appendChild(updateButton);
    // updateButton.classList.add("btn", "btn-secondary", "updateButton");
    // updateButton.setAttribute("id", `btn_${product.id}`)
    // updateButton.innerHTML = "Update";
  });
};

const deleteProduct = (id) => {
  console.log(id);
  $.ajax({
    method: "DELETE",
    url: `/practice/Project/routes/web.php/v1/deleteProduct?id=${id}`,
    success: function (result) {
      console.log(result);
      if (result.status == 200) {
        document.getElementsByClassName("products")[0].innerHTML = "";
        window.location.reload();
      } else {
        document.getElementsByClassName("products")[0].innerHTML =
          result.message;
      }
    },
  });
};
