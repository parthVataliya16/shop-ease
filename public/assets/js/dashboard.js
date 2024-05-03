$(document).ready(function() {
    $.ajax ({
        method: "GET",
        url: "/Project/routes/web.php/v1/orderGraph", // Adjust the URL path as needed
        success: function (result) {
            console.log(result);
            if (result && result.status === 200 && result.products) {
                let labels = [];
                let values = [];

                for (let i = 0; i < 10; i += 2) {
                    let product = result.products[i];
                    let quantity = result.products[i + 1];

                    labels.push(product.length >= 15 ? product.slice(0, 15) : product);
                    values.push(quantity);
                }

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Quantity',
                            data: values,
                            backgroundColor: 'blue', // Adjust color as needed
                        }]
                    },
                    options: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: "Top Selling"
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.yLabel;
                                }
                            }
                        }
                    }
                });        
            } else {
                console.error("Invalid data received from the server.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error occurred. Status:", status, "Error:", error);
        }
    });
    $.ajax({
        method: "GET",
        url: "/Project/routes/web.php/v1/mostFavourite",
        success: function(result) {
            console.log(result);
            if (result && result.status === 200 && result.product) {
                let labels = [];
                let values = [];
                const barColors = [
                    "#b91d47",
                    "#00aba9",
                    "#2b5797",
                    "#e8c3b9",
                    "#1e7145"
                ];
    
                result.product.forEach(product => {
                    labels.push(product.name.length >= 15 ? product.name.slice(0, 15) : product.name);
                    values.push(product.number_of_product);
                });
    
                var ctx = document.getElementById('mostFavourite').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: barColors.slice(0, values.length), // Adjust color as needed
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "Most Favorite Products"
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var dataset = data.datasets[tooltipItem.datasetIndex];
                                    var total = dataset.data.reduce((previousValue, currentValue) => previousValue + currentValue);
                                    var currentValue = dataset.data[tooltipItem.index];
                                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5); // Round to nearest integer
                                    return `${data.labels[tooltipItem.index]}: ${currentValue} (${percentage}%)`;
                                }
                            }
                        }
                    }
                });
            } else {
                console.error("Invalid data received from the server.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error occurred. Status:", status, "Error:", error);
        }
    });
    
});
