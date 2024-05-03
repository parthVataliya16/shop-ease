$(document).ready(function() {
    $.ajax ({
        method: 'GET',
        url: `/Project/routes/web.php/v1/allOrders`,
        success: function(result) {
            console.log(result);
            if (result.status == 200) {
                $(".loader").addClass("hideLoader");
                $(".ordertable").removeClass("hideLoader");
                $(".sidebar").removeClass("hideLoader");

                result.orders.forEach((order, index) => {
                    const tableRow = document.createElement("tr");
                    document.getElementsByClassName("orders")[0].appendChild(tableRow);
                    tableRow.classList.add("orderData");

                    const userName = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(userName);
                    userName.innerHTML = order.user_name;

                    const phoneNumber = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(phoneNumber);
                    phoneNumber.innerHTML = order.phone_number;

                    const productName = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(productName);
                    productName.innerHTML = order.product_name;

                    const quantity = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(quantity);
                    quantity.innerHTML = order.quantity;

                    const status = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(status);
                    status.classList.add("status", order.status);
                    status.innerHTML = `<p>${order.status}</p>`

                    const actionButtons = document.createElement("td");
                    document.getElementsByClassName("orderData")[index].appendChild(actionButtons);
                    actionButtons.classList.add("actionButtons");

                    const viewOrderButton = document.createElement("i");
                    document.getElementsByClassName("actionButtons")[index].appendChild(viewOrderButton);
                    viewOrderButton.classList.add("fa-solid", "fa-eye", "col-6");
                    viewOrderButton.setAttribute("data-bs-toggle", "modal");
                    viewOrderButton.setAttribute("data-bs-target", "#viewOrder");
                    viewOrderButton.setAttribute("id", order.id);

                    const updateOrderStatusButton = document.createElement("i");
                    document.getElementsByClassName("actionButtons")[index].appendChild(updateOrderStatusButton);
                    updateOrderStatusButton.classList.add("fa-solid", "fa-pen-to-square", "col-6");
                    updateOrderStatusButton.setAttribute("data-bs-toggle", "modal")
                    updateOrderStatusButton.setAttribute("data-bs-target", "#updateOrderStatus");
                    updateOrderStatusButton.setAttribute("id", order.id);

                    $("#orderStatus").change(function() {
                        if ($(this).val() != 'accept') {
                            $(".deliveryDay").hide();
                        } else {
                            $(".deliveryDay").show();
                        }
                    });

                    $(".fa-pen-to-square").click(function() {
                        $("#updateOrdere").attr('data', $(this).attr("id"));
                    });
                    

                    $("#updateOrdere").unbind().click(function(event) {
                        event.preventDefault();
                        $(".loader").removeClass("hideLoader");
                        $(".modal-dialog").addClass("hideLoader");
                        const status = $("#orderStatus").val();
                        console.log(status);
                        let day;
                        if (status != 'accepted') {
                            day = 0;
                        } else {
                            day = $("#deliveryDay").val();
                        }
                        const id = $(this).attr("data");
                        console.log(id);
                        $.ajax ({
                            method: "POST",
                            url: `/Project/routes/web.php/v1/updateOrderStatus/${id}`,
                            data: {
                                day: day,
                                status: status
                            },
                            success: function (result) {
                                $(".loader").addClass("hideLoader");
                                console.log(result);
                                window.location.reload();
                            }
                        })
                    })
                });

                $(".table").DataTable();
            }

            $(".fa-eye").click(function(){
                const id = $(this).attr("id");
                $.ajax ({
                    method:"GET",
                    url: `/Project/routes/web.php/v1/order/${id}`,
                    success: function (result) {
                        console.log(result);
                        if (result.status == 200) {
                            result.product.forEach(product => {
                                console.log("object");
                                document.getElementById("productName").innerHTML = product.product_name;
                                document.getElementById("userName").innerHTML = product.user_name;
                                document.getElementById("userContact").innerHTML = product.phone_number;
                                document.getElementById("quantity").innerHTML = product.quantity;
                                document.getElementById("paymentType").innerHTML = product.payment_option;
                                document.getElementById("paymentStatus").innerHTML = product.payment_status;
                            })
                        }
                    }
                })
            });
            
        }
    })
})
