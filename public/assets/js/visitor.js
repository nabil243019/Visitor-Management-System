/*
==========================================
Visitor Javascript
==========================================
*/

const searchInput = document.getElementById("searchVisitor");

const statusFilter = document.getElementById("filterStatus");

const tableBody = document.getElementById("visitorTable");

const visitorCountText = document.getElementById("visitorCountText");

const pollUrl = tableBody.dataset.pollUrl;

/*
==========================================
State
==========================================
*/

let currentVisitors = [];

/*
==========================================
Render Table Rows
==========================================
*/

function statusBadge(status) {

    if (status === "Masuk") {
        return '<span class="badge bg-success">Masih Di Dalam</span>';
    }

    return '<span class="badge bg-secondary">Sudah Check Out</span>';

}

function renderRows(visitors) {

    if (visitors.length === 0) {

        tableBody.innerHTML = `
            <tr>
                <td colspan="10" class="text-center text-muted py-4">
                    Belum ada data visitor.
                </td>
            </tr>
        `;

        return;

    }

    tableBody.innerHTML = visitors.map(function (visitor, index) {

        const blacklistBadge = visitor.blacklisted
            ? '<span class="badge bg-danger">Blacklist</span>'
            : '';

        const blacklistButton = !visitor.blacklisted
            ? `
                <button
                    type="button"
                    class="btn btn-outline-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#blacklistModal"
                    data-visitor-id="${visitor.id}"
                    data-visitor-nama="${visitor.nama}">

                    <i class="bi bi-slash-circle"></i>

                </button>
            `
            : '';

        return `
            <tr>
                <td>${index + 1}</td>
                <td>${visitor.nama}</td>
                <td>${visitor.email}</td>
                <td>${visitor.no_hp}</td>
                <td>${visitor.perusahaan}</td>
                <td>${visitor.tujuan}</td>
                <td>${visitor.nomor_rak}</td>
                <td>${visitor.check_in}</td>
                <td>${statusBadge(visitor.status)} ${blacklistBadge}</td>
                <td>
                    <a href="${visitor.detail_url}" class="btn btn-primary btn-sm">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    ${blacklistButton}
                </td>
            </tr>
        `;

    }).join("");

    if (visitorCountText) {
        visitorCountText.textContent =
            `Menampilkan 1 - ${visitors.length} dari ${visitors.length} data visitor`;
    }

}

/*
==========================================
Apply Search + Status Filter
==========================================
*/

function applyFilters() {

    const keyword = searchInput.value.toLowerCase();

    const statusValue = statusFilter.value.toLowerCase();

    let filtered = currentVisitors;

    if (keyword !== "") {

        filtered = filtered.filter(function (visitor) {

            const haystack = Object.values(visitor).join(" ").toLowerCase();

            return haystack.includes(keyword);

        });

    }

    if (statusValue !== "") {

        filtered = filtered.filter(function (visitor) {

            if (statusValue === "blacklist") {
                return visitor.blacklisted;
            }

            const statusLabel = visitor.status === "Masuk"
                ? "masih di dalam"
                : "sudah check out";

            return statusLabel.includes(statusValue);

        });

    }

    renderRows(filtered);

}

searchInput.addEventListener("keyup", applyFilters);

statusFilter.addEventListener("change", applyFilters);

/*
==========================================
Fetch Visitors (Polling)
==========================================
*/

async function fetchVisitors() {

    try {

        const response = await fetch(pollUrl, {
            headers: { "Accept": "application/json" },
        });

        if (!response.ok) return;

        const result = await response.json();

        currentVisitors = result.visitors;

        applyFilters();

    } catch (error) {

        console.error("Gagal memuat data visitor:", error);

    }

}

/*
==========================================
Page Ready
==========================================
*/

window.addEventListener("load", function () {

    fetchVisitors();

    setInterval(fetchVisitors, 5000);

});