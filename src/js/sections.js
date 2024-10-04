document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[name="options"]');
    const gradeSections = document.querySelectorAll('.grade-section');

    // Function to display the selected grade section
    function filterGradeLevel() {
        const selectedGrade = document.querySelector('input[name="options"]:checked').value;

        gradeSections.forEach(section => {
            if (section.dataset.grade === selectedGrade) {
                section.style.display = 'block'; // Show the selected grade section
            } else {
                section.style.display = 'none'; // Hide the other sections
            }
        });
    }

    // Initial filter call to show the default selected grade
    filterGradeLevel();

    // Add event listeners to radio buttons
    radioButtons.forEach(radio => {
        radio.addEventListener('change', filterGradeLevel);
    });
});
