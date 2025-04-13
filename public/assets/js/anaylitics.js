$(document).ready(function () {
    const donorsList = $("#donorsList");
    let chart;

    function fetchTopDonors() {
        $.ajax({
            url: "/admin/fetch-top-donors",
            method: "GET",
            success: function (response) {
                donorsList.empty();
                if (response.length > 0) {
                    response.forEach((donor) => {
                        donorsList.append(`
                            <li>
                                <div class="d-flex align-items-top flex-wrap">
                                    <div class="me-2">
                                        <span class="avatar avatar-sm avatar-rounded bg-primary-transparent fw-semibold">
                                            ${donor.name.charAt(0)}
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <p class="fw-semibold mb-0">${
                                            donor.name
                                        }</p>
                                        <span class="text-muted fs-12">${
                                            donor.email
                                        }</span>
                                    </div>
                                    <div class="fw-semibold fs-15">$${
                                        donor.total_donations
                                    }</div>
                                </div>
                            </li>
                        `);
                    });
                } else {
                    donorsList.append(`<li>No donors found.</li>`);
                }
            },
            error: function (xhr) {
                console.error("An error occurred: ", xhr);
            },
        });
    }

    function fetchAnalytics() {
        fetch(`/admin/analytics`)
            .then((response) => response.json())
            .then((data) => {
                updateChart(data.expenseData, data.budgetData);
            })
            .catch((error) => console.error("Error fetching data:", error));
    }

    function updateChart(expenseData, budgetData) {
        var options = {
            series: [
                { type: "line", name: "Expenses", data: expenseData },
                { type: "line", name: "Budgets", data: budgetData },
            ],
            chart: {
                height: 350,
                animations: { speed: 500 },
                dropShadow: {
                    enabled: true,
                    top: 8,
                    blur: 3,
                    color: "#000",
                    opacity: 0.1,
                },
            },
            colors: ["rgb(255, 99, 132)", "rgb(54, 162, 235)"],
            dataLabels: { enabled: false },
            grid: { borderColor: "#f1f1f1", strokeDashArray: 3 },
            stroke: { curve: "smooth", width: [2, 2] },
            xaxis: { axisTicks: { show: false } },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return "$" + value;
                    },
                },
            },
            tooltip: {
                y: [
                    { formatter: (e) => "$" + e.toFixed(0) },
                    { formatter: (e) => "$" + e.toFixed(0) },
                ],
            },
            markers: { hover: { sizeOffset: 5 } },
        };

        if (chart) {
            chart.updateOptions(options);
        } else {
            chart = new ApexCharts(
                document.querySelector("#crm-expense-analytics"),
                options
            );
            chart.render();
        }
    }

    function fetchRevenueAnalytics() {
        fetch(`/admin/analytics/revenue`)
            .then((response) => response.json())
            .then((data) => {
                const months = data.revenueData.map((item) => item.month);
                const revenues = data.revenueData.map((item) => item.revenue);
                updateRevenueChart(months, revenues);
            })
            .catch((error) =>
                console.error("Error fetching revenue data:", error)
            );
    }

    function updateRevenueChart(months, revenueData) {
        var options = {
            series: [
                {
                    name: "Revenue",
                    data: revenueData,
                },
            ],
            chart: {
                type: "line",
                height: 350,
                animations: { speed: 500 },
            },
            colors: ["#00C292"],
            dataLabels: { enabled: false },
            stroke: { curve: "smooth", width: 3 },
            xaxis: {
                categories: months,
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return "$" + value;
                    },
                },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$" + val.toFixed(2);
                    },
                },
            },
        };

        const chartContainer = document.querySelector("#crm-revenue-month");

        if (!window.revenueChart) {
            window.revenueChart = new ApexCharts(chartContainer, options);
            window.revenueChart.render();
        } else {
            window.revenueChart.updateOptions(options);
        }
    }

    let donationChart = null;

    function fetchDonations() {
        fetch("/admin/analytics/donation")
            .then((response) => response.json())
            .then((data) => {
                if (data && Array.isArray(data.donationData)) {
                    updateDonationChart(data.donationData);
                } else {
                    console.error("Invalid data format:", data);
                }
            })
            .catch((error) => {
                console.error("Error fetching donation data:", error);
            });
    }

    function updateDonationChart(donationData) {
        const months = donationData.map((item) => item.month);
        const donations = donationData.map((item) => item.donations);

        const options = {
            series: [
                {
                    name: "Donations",
                    data: donations,
                },
            ],
            chart: {
                type: "line",
                height: 350,
                animations: {
                    speed: 500,
                },
                dropShadow: {
                    enabled: true,
                    top: 8,
                    blur: 3,
                    color: "#000",
                    opacity: 0.1,
                },
            },
            colors: ["#28a745"],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },
            grid: {
                borderColor: "#f1f1f1",
                strokeDashArray: 3,
            },
            xaxis: {
                categories: months,
                labels: {
                    style: {
                        fontSize: "12px",
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: (value) => value,
                },
            },
            tooltip: {
                y: {
                    formatter: (val) => `${val} donations`,
                },
            },
            markers: {
                hover: {
                    sizeOffset: 5,
                },
            },
        };

        if (donationChart) {
            donationChart.destroy();
        }

        donationChart = new ApexCharts(
            document.querySelector("#donation-chart"),
            options
        );
        donationChart.render();
    }

    // Load chart on page load
    fetchDonations();

    // Fetch data on page load
    fetchTopDonors();
    fetchAnalytics();
    fetchRevenueAnalytics();
});
