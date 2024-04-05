import { tostifyBox } from "./functions.js";

window.onload = () => {
    const mrp = localStorage.getItem("mrp");
    const discountMRP = localStorage.getItem("discountMRP");
    const amount = localStorage.getItem("amount");
    document.getElementsByClassName("mrp")[0].innerHTML = mrp;
    document.getElementsByClassName("discountMRP")[0].innerHTML = discountMRP;
    document.getElementsByClassName("amount")[0].innerHTML = amount;

    getAddress();

    $.ajax ({
        method: 'POST',
        url: `/practice/Project/routes/web.php/v1/placeOrder`,
        data: {
            amount: mrp
        },
        success: function(result) {
            console.log(result);
            const script = document.createElement("script");
            document.getElementById("placeOrder").appendChild(script);
            script.setAttribute("src", "https://checkout.razorpay.com/v1/checkout.js");
            script.setAttribute("data-key", result.apiKey);
            script.setAttribute("data-amount", result.amount);
            script.setAttribute("data-currency", "INR");
            script.setAttribute("data-order-id", result.id);
            script.setAttribute("data-buttontext", "Place order");
            script.setAttribute("data-name", "Shop ease");
            script.setAttribute("data-description", "product detail");
        }
    })
}

const getAddress = () => {
    $.ajax({
        method: 'GET',
        url: `/practice/Project/routes/web.php/v1/address`,
        success: function(result) {
            if (result.status == 200) {
                result.address.forEach((value, index) => {
                    const userAddress = document.createElement("div");
                    document.getElementsByClassName("allAddresses")[0].appendChild(userAddress);
                    userAddress.classList.add("userAddress", "d-flex", "align-items-center");

                    const selectAddress = document.createElement("input");
                    document.getElementsByClassName("userAddress")[index].appendChild(selectAddress);
                    selectAddress.classList.add("selectAddress");
                    selectAddress.setAttribute("type", "radio");
                    selectAddress.setAttribute("name", "address");
                    selectAddress.setAttribute("id", value.id);

                    const address = document.createElement("p");
                    document.getElementsByClassName("userAddress")[index].appendChild(address);
                    address.classList.add("address", "p-0", "mb-0", "ms-2");
                    address.innerHTML = `${value.street}, ${value.town}, ${value.city}, ${value.state} - ${value.pincode}`;

                    const editAddress = document.createElement("i");
                    document.getElementsByClassName("userAddress")[index].appendChild(editAddress);
                    editAddress.classList.add("fa-regular", "fa-pen-to-square", "ms-2", "editAddress");
                    editAddress.setAttribute("data-bs-toggle", "modal");
                    editAddress.setAttribute("data-bs-target", "#editAddress");
                    editAddress.setAttribute("id", value.id);
                });

                $("input[type='radio']:first").attr("checked", "");
                const defaultSelectedRadio =  $("input[type='radio']:first").attr("id");
                localStorage.setItem("addressId", defaultSelectedRadio);

                const addressRadioButtons = document.querySelectorAll("input[type='radio']");
                addressRadioButtons.forEach(button => {
                    button.addEventListener("click", () => {
                        localStorage.setItem("addressId", button.getAttribute("id"));
                    })
                })

                const editAddress = document.querySelectorAll(".editAddress");
                editAddress.forEach(edit => {
                    edit.addEventListener("click", () => {
                        const id = edit.getAttribute("id");
                        $.ajax({
                            method: 'GET',
                            url: `/practice/Project/routes/web.php/v1/address/${id}`,
                            success: function(result) {
                                if (result.status == 200) {
                                    document.getElementById("street").value = result.address[0].street;
                                    document.getElementById("pincode").value = result.address[0].pincode;
                                    document.getElementById("town").value = result.address[0].town;
                                    document.getElementById("city").value = result.address[0].city;
                                    document.getElementById("state").value = result.address[0].state;
                                    document.getElementById("updateAddress").setAttribute("data", result.address[0].id);
                                }
                            }
                        })
                    })
                })
            }
        }
    });

}

const addAddress = document.getElementById("newAddress");
addAddress.addEventListener("click", () => {
    const street = document.getElementById("newStreet").value;
    const pincode = document.getElementById("newPincode").value;
    const town = document.getElementById("newTown").value;
    const city = document.getElementById("newCity").value;
    const state = document.getElementById("newState").value;
    $.ajax({
        method: 'POST',
        url: `/practice/Project/routes/web.php/v1/addAddress`,
        data: {
            street: street,
            town: town,
            city: city,
            state: state,
            pincode: pincode
        },  
        success: function(result) {
            console.log(result);
            const response = JSON.parse(result);
            if (response.status == 200) {
                window.location.reload();
            } else {
                tostifyBox("Something wend wrong!", "linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%)", "#000000");
            }
        }
    });
});

const updateAddress = document.getElementById("updateAddress");
updateAddress.addEventListener("click", () => {
    const street = document.getElementById("street").value;
    const pincode = document.getElementById("pincode").value;
    const town = document.getElementById("town").value;
    const city = document.getElementById("city").value;
    const state = document.getElementById("state").value;
    const id = updateAddress.getAttribute("data");

    $.ajax({
        method: 'POST',
        url: `/practice/Project/routes/web.php/v1/updateAddress/${id}`,
        data: {
            street: street,
            town: town,
            city: city,
            state: state,
            pincode: pincode
        },  
        success: function(result) {
            if (result.status == 200) {
                window.location.reload();
            } else {
                tostifyBox("Something wend wrong!", "linear-gradient(#ff4040, #f9a98a)", "#000000");
            }
        }
    })
})

export {getAddress} 