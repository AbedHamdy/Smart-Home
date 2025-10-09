// File upload handler
const fileInput = document.getElementById("cv_file");
const fileName = document.getElementById("fileName");

fileInput.addEventListener("change", function (e) {
    if (this.files && this.files[0]) {
        fileName.textContent = "✓ " + this.files[0].name;
        fileName.style.display = "block";
    } else {
        fileName.style.display = "none";
    }
});

// Add icons focus effect
const inputs = document.querySelectorAll(
    'input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select'
);
inputs.forEach((input) => {
    input.addEventListener("focus", function () {
        const icon = this.nextElementSibling;
        if (icon && icon.classList.contains("input-icon")) {
            icon.style.transform = "translateY(-50%) scale(1.1)";
        }
    });

    input.addEventListener("blur", function () {
        const icon = this.nextElementSibling;
        if (icon && icon.classList.contains("input-icon")) {
            icon.style.transform = "translateY(-50%) scale(1)";
        }
    });
});

document.querySelectorAll(".category-checkbox").forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        if (this.checked) {
            document.querySelectorAll(".category-checkbox").forEach((cb) => {
                if (cb !== this) cb.checked = false;
            });
        }
    });
});
