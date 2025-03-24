$(document).ready(function () {
    const churchSelect = $("#churchSelect");
    const donorsList = $("#donorsList");

    // Fetch top donors for the first church on page load
    let firstChurchId = churchSelect.find("option:first").next().val(); // Get the first church ID (skipping the placeholder)
    if (firstChurchId) {
        fetchTopDonors(firstChurchId);
    }

    // On change of dropdown
    churchSelect.on("change", function () {
        let churchId = $(this).val();
        fetchTopDonors(churchId);
    });

    function fetchTopDonors(churchId) {
        $.ajax({
            url: "/admin/fetch-top-donors",
            method: "GET",
            data: { church_id: churchId },
            success: function (response) {
                donorsList.empty();
                if (response.length > 0) {
                    response.forEach((donor) => {
                        donorsList.append(`
                            <li>
                                <div class="d-flex align-items-top flex-wrap">
                                    <div class="me-2">
                                        <span class="avatar avatar-sm avatar-rounded bg-primary-transparent fw-semibold">
                                            ${donor.first_name.charAt(
                                                0
                                            )}${donor.last_name.charAt(0)}
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <p class="fw-semibold mb-0">${
                                            donor.first_name
                                        } ${donor.last_name}</p>
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
                    donorsList.append(
                        `<li>No donors found for this church.</li>`
                    );
                }
            },
            error: function (xhr) {
                console.error("An error occurred: ", xhr);
                alert("Failed to fetch donors. Please try again.");
            },
        });
    }
});
