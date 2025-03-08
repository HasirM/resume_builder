// Global variables to store current editing item ID
let currentEditId = null;

// Show modal function
function showModal(modalId) {
  document.getElementById(modalId + "-modal").style.display = "flex";
  // //console.log("Modal " + modalId + " opened");
}

// Hide all modals function
function hideAllModals() {
  const modals = document.querySelectorAll(".modal-overlay");
  modals.forEach((modal) => {
    modal.style.display = "none";
  });
  // Reset current edit ID
  currentEditId = null;
}

// Close modal buttons
document.querySelectorAll(".modal-close").forEach((btn) => {
  btn.addEventListener("click", hideAllModals);
});

// Add buttons event listeners
document.querySelectorAll(".add-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    const type = this.getAttribute("data-type");
    currentEditId = null; // Reset current edit ID

    // Reset the form for the modal type
    const form = document.getElementById(`${type}-form`);
    if (form) {
      form.reset(); // Reset the form fields
    }

    showModal(type); // Show the modal
  });
});

// Edit buttons event listeners
document.querySelectorAll(".edit-icon").forEach((icon) => {
  icon.addEventListener("click", function () {
    const type = this.getAttribute("data-type");
    const id = this.getAttribute("data-id");
    currentEditId = id;

    //console.log("Editing " + type + " with ID: " + id);

    // Populate form with existing data based on type

    //console.log("showing modal for " + type);
    // Show the appropriate modal
    showModal(type);
    populateEditForm(type, id);
  });
});

// Function to populate edit form with existing data
function populateEditForm(type, id) {
  //console.log("pupulate form working", type, id);
  const element = document.getElementById(id);

  if (!element) return;

  switch (type) {
    case "profile":
      document.getElementById("profile-id").value = id
        .replace("profile-", "")
        .trim();
      break;

    case "objective":
      document.getElementById("objective-id").value = id
        .replace("objective-", "")
        .trim();
      document.getElementById("objective-text").value = element
        .querySelector(".entry-description")
        .textContent.trim();
      break;

    case "personal":
      document.getElementById("personal-id").value = id
        .replace("personal-", "")
        .trim();
      // Populate Full Name
      document.getElementById("personal-name").value = document
        .querySelector(".name-section h2")
        .textContent.replace("✏️", "")
        .trim();

      // Populate Email
      document.getElementById("personal-email").value =
        document.querySelector(".contact-info").textContent;

      // Populate Phone Number
      document.getElementById("personal-phone").value =
        document.querySelectorAll(".contact-info")[1].textContent;

      // Populate Location
      document.getElementById("personal-location").value =
        document.querySelector(".location").textContent;

      // Populate Designation
      const designationElement = document.querySelector(".designation");
      document.getElementById("personal-designation").value = designationElement
        ? designationElement.textContent
        : "";

      // Populate Website
      const websiteElement = document.querySelector(".website a");
      document.getElementById("personal-website").value = websiteElement
        ? websiteElement.getAttribute("href")
        : "";

      // Populate GitHub Profile
      const githubElement = document.querySelector(".github a");
      document.getElementById("personal-github").value = githubElement
        ? githubElement.getAttribute("href")
        : "";

      // Populate LinkedIn Profile
      const linkedinElement = document.querySelector(".linkedin a");
      document.getElementById("personal-linkedin").value = linkedinElement
        ? linkedinElement.getAttribute("href")
        : "";
      break;

    case "education":
      document.getElementById("education-id").value = id
        .replace("education-", "")
        .trim();
      document.getElementById("education-college").value =
        element.querySelector(".entry-subtitle").textContent;

      const eduDates = element
        .querySelector(".entry-date")
        .textContent.split(" - ");
      document.getElementById("education-start-year").value = eduDates[0];
      document.getElementById("education-end-year").value = eduDates[1];

      document.getElementById("education-degree").value =
        element.querySelector(".entry-title").textContent;

      // Stream might not exist
      const streamElement = element.querySelectorAll(".entry-subtitle")[1];
      if (streamElement) {
        document.getElementById("education-stream").value =
          streamElement.textContent.replace("(board)", "").trim();
      }

      // Extract score
      const scoreText = element.querySelector(".percentage").textContent;
      if (scoreText.includes("CGPA")) {
        document.getElementById("education-score-type").value = "cgpa";
        document.getElementById("education-score").value = scoreText
          .split(":")[1]
          .trim();
      } else {
        document.getElementById("education-score-type").value = "percentage";
        document.getElementById("education-score").value = scoreText
          .split(":")[1]
          .trim()
          .replace("%", "");
      }
      break;

    case "experience":
      document.getElementById("experience-id").value = id
        .replace("experience-", "")
        .trim();

      // Populate profile, organization, and location
      document.getElementById(`experience-profile`).value =
        element.querySelector(".entry-title").textContent;

      const orgLocation = element
        .querySelector(".entry-subtitle")
        .textContent.split(", ");
      document.getElementById(`experience-organization`).value = orgLocation[0];
      document.getElementById(`experience-location`).value =
        orgLocation[1] || "";

      // Parse and populate dates
      const dateText = element.querySelector(".entry-date").textContent.trim();
      const dates = dateText.split(" - ");

      // Convert start date to YYYY-MM-DD format
      const startDateParts = dates[0].split(" "); // Split the date string into parts
      const startDay = startDateParts[0]; // e.g., "31"
      const startMonth = startDateParts[1]; // e.g., "Jan"
      const startYear = startDateParts[2]; // e.g., "2023"
      const startDate = `${startYear}-${getMonthNumber(
        startMonth
      )}-${startDay}`; // Convert to YYYY-MM-DD
      document.getElementById(`experience-start-date`).value = startDate;

      // Convert end date to YYYY-MM-DD format
      const endDateParts = dates[1].split(" "); // Split the date string into parts
      if (endDateParts[0].toLowerCase() === "present") {
        // If the end date is "Present", leave the end date field empty
        document.getElementById(`experience-end-date`).value = "";
      } else {
        const endDay = endDateParts[0]; // e.g., "31"
        const endMonth = endDateParts[1]; // e.g., "Dec"
        const endYear = endDateParts[2]; // e.g., "2023"
        const endDate = `${endYear}-${getMonthNumber(endMonth)}-${endDay}`; // Convert to YYYY-MM-DD
        document.getElementById(`experience-end-date`).value = endDate;
      }

      // Helper function to convert month name to month number
      function getMonthNumber(monthName) {
        const months = {
          Jan: "01",
          Feb: "02",
          Mar: "03",
          Apr: "04",
          May: "05",
          Jun: "06",
          Jul: "07",
          Aug: "08",
          Sep: "09",
          Oct: "10",
          Nov: "11",
          Dec: "12",
        };
        return months[monthName];
      }

      // Populate description
      document.getElementById(`experience-description`).value = element
        .querySelector(".entry-description")
        .textContent.trim();
      break;

    case "skill":
      document.getElementById("skill-id").value = id
        .replace("skill-", "")
        .trim();
      document.getElementById("area-of-expertise").value =
        element.querySelector(".skill-text").textContent;
      document.getElementById("skills-acquired").value =
        element.querySelector(".skill-acquired").textContent;
      break;

    case "project":
      document.getElementById("project-id").value = id
        .replace("project-", "")
        .trim();
      document.getElementById("project-title").value =
        element.querySelector(".entry-title").textContent;

      const projectDates = element
        .querySelector(".entry-date")
        .textContent.split(" - ");
      const projectStartDate = projectDates[0].split(" ");
      const projectEndDate = projectDates[1].split(" ");

      document.getElementById("project-start-month").value =
        projectStartDate[0];
      document.getElementById("project-start-year").value = projectStartDate[1];
      document.getElementById("project-end-month").value = projectEndDate[0];
      document.getElementById("project-end-year").value = projectEndDate[1];

      const projectLink = element.querySelector(".project-link");
      if (projectLink) {
        document.getElementById("project-url").value = projectLink.textContent;
      }

      document.getElementById("project-description").value = element
        .querySelector(".entry-description")
        .textContent.trim()
        .replace("... show more", "");
      break;

    case "language":
      document.getElementById("language-id").value = id
        .replace("language-", "")
        .trim();
      document.getElementById("language-name").value =
        element.querySelector(".language-name").textContent;
      const proficiencyText = element
        .querySelector(".language-proficiency")
        .textContent.trim();

      // Get the select element
      const proficiencySelect = document.getElementById("language-proficiency");

      // Loop through the options and set the selected option based on the text content
      for (let option of proficiencySelect.options) {
        if (option.text === proficiencyText) {
          proficiencySelect.value = option.value;
          break; // Exit the loop once the matching option is found
        }
      }
      break;

    case "certificate":
      document.getElementById("certificate-id").value = id
        .replace("certificate-", "")
        .trim();
      document.getElementById("certificate-name").value =
        element.querySelector(".certificate-title").textContent;
      document.getElementById("certificate-organization").value = element.querySelector(
        ".certificate-organisation"
      ).textContent;
      document.getElementById("certificate-url").value =
        element.querySelector(".certificate-link").textContent;
      document.getElementById("certificate-description").value = element.querySelector(
        ".certificate-description"
      ).textContent;
  }
}

// Save button event listeners
// document.getElementById('save-personal').addEventListener('click', function() {
//     const name = document.getElementById('personal-name').value;
//     const email = document.getElementById('personal-email').value;
//     const phone = document.getElementById('personal-phone').value;
//     const location = document.getElementById('personal-location').value;

//     document.querySelector('.name-section h2').innerHTML = name + ' <span class="edit-icon" data-type="personal">✏️</span>';
//     document.querySelector('.contact-info').textContent = email;
//     document.querySelectorAll('.contact-info')[1].textContent = phone;
//     document.querySelector('.location').textContent = location;

//     hideAllModals();
// });

// document.getElementById('save-objective').addEventListener('click', function() {
//     const objectiveText = document.getElementById('objective-text').value;

//     if (currentEditId) {
//         // Update existing objective
//         const element = document.getElementById(currentEditId);
//         element.querySelector('.entry-description').textContent = objectiveText;
//     } else {
//         // Add new objective
//         const objectiveContainer = document.querySelector('.section-content');
//         const newObjective = document.createElement('div');
//         newObjective.className = 'entry';
//         newObjective.id = 'career-objective-' + Date.now();
//         newObjective.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-description">
//                     ${objectiveText}
//                 </div>
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="objective" data-id="${newObjective.id}">✏️</span>
//                 <span class="delete-icon" data-id="${newObjective.id}">🗑️</span>
//             </div>
//         `;
//         objectiveContainer.appendChild(newObjective);

//         // Add event listeners to new buttons
//         newObjective.querySelector('.edit-icon').addEventListener('click', function() {
//             const type = this.getAttribute('data-type');
//             const id = this.getAttribute('data-id');
//             currentEditId = id;
//             populateEditForm(type, id);
//             showModal(type);
//         });

//         newObjective.querySelector('.delete-icon').addEventListener('click', function() {
//             const id = this.getAttribute('data-id');
//             if (confirm('Are you sure you want to delete this item?')) {
//                 document.getElementById(id).remove();
//             }
//         });
//     }

//     hideAllModals();
// });

// document.getElementById('save-education').addEventListener('click', function() {
//     const college = document.getElementById('education-college').value;
//     const startYear = document.getElementById('education-start-year').value;
//     const endYear = document.getElementById('education-end-year').value;
//     const degree = document.getElementById('education-degree').value;
//     const stream = document.getElementById('education-stream').value;
//     const scoreType = document.getElementById('education-score-type').value;
//     const score = document.getElementById('education-score').value;

//     const scoreText = scoreType === 'cgpa' ? `CGPA: ${score}` : `Percentage: ${score}%`;

//     if (currentEditId) {
//         // Update existing education
//         const element = document.getElementById(currentEditId);
//         element.querySelector('.entry-title').textContent = degree;
//         element.querySelector('.entry-subtitle').textContent = college;
//         element.querySelector('.entry-date').textContent = `${startYear} - ${endYear}`;
//         element.querySelector('.percentage').textContent = scoreText;
//     } else {
//         // Add new education
//         const educationContainer = document.getElementById('education-container');
//         const newEducation = document.createElement('div');
//         newEducation.className = 'entry';
//         newEducation.id = 'education-' + Date.now();
//         newEducation.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-title">${degree}</div>
//                 <div class="entry-subtitle">${college}</div>
//                 ${stream ? `<div class="entry-subtitle">${stream}</div>` : ''}
//                 <div class="entry-date">${startYear} - ${endYear}</div>
//                 <div class="percentage">${scoreText}</div>
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="education" data-id="${newEducation.id}">✏️</span>
//                 <span class="delete-icon" data-id="${newEducation.id}">🗑️</span>
//             </div>
//         `;
//         educationContainer.appendChild(newEducation);

//         // Add event listeners to new buttons
//         newEducation.querySelector('.edit-icon').addEventListener('click', function() {
//             const type = this.getAttribute('data-type');
//             const id = this.getAttribute('data-id');
//             currentEditId = id;
//             populateEditForm(type, id);
//             showModal(type);
//         });

//         newEducation.querySelector('.delete-icon').addEventListener('click', function() {
//             const id = this.getAttribute('data-id');
//             if (confirm('Are you sure you want to delete this item?')) {
//                 document.getElementById(id).remove();
//             }
//         });
//     }

//     hideAllModals();
// });

// document.getElementById("save-job").addEventListener("click", function () {
//   const profile = document.getElementById("job-profile").value;
//   const organization = document.getElementById("job-organization").value;
//   const location = document.getElementById("job-location").value;
//   const startMonth = document.getElementById("job-start-month").value;
//   const startYear = document.getElementById("job-start-year").value;
//   const endMonth = document.getElementById("job-end-month").value;
//   const endYear = document.getElementById("job-end-year").value;
//   const description = document.getElementById("job-description").value;

//   if (currentEditId) {
//     // Update existing job
//     const element = document.getElementById(currentEditId);
//     element.querySelector(".entry-title").textContent = profile;
//     element.querySelector(
//       ".entry-subtitle"
//     ).textContent = `${organization}, ${location}`;
//     element.querySelector(
//       ".entry-date"
//     ).textContent = `Job • ${startMonth} ${startYear} - ${endMonth} ${endYear}`;
//     element.querySelector(".entry-description").textContent = description;
//   } else {
//     // Add new job
//     const experienceContainer = document.getElementById("experience-container");
//     const newJob = document.createElement("div");
//     newJob.className = "entry";
//     newJob.id = "experience-" + Date.now();
//     newJob.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-title">${profile}</div>
//                 <div class="entry-subtitle">${organization}, ${location}</div>
//                 <div class="entry-date">Job • ${startMonth} ${startYear} - ${endMonth} ${endYear}</div>
//                 <div class="entry-description">${description}</div>
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="experience" data-id="${newJob.id}">✏️</span>
//                 <span class="delete-icon" data-id="${newJob.id}">🗑️</span>
//             </div>
//         `;
//     experienceContainer.appendChild(newJob);

//     // Add event listeners to new buttons
//     newJob.querySelector(".edit-icon").addEventListener("click", function () {
//       const type = this.getAttribute("data-type");
//       const id = this.getAttribute("data-id");
//       currentEditId = id;
//       populateEditForm(type, id);
//       showModal(type);
//     });

//     newJob.querySelector(".delete-icon").addEventListener("click", function () {
//       const id = this.getAttribute("data-id");
//       if (confirm("Are you sure you want to delete this item?")) {
//         document.getElementById(id).remove();
//       }
//     });
//   }

//   hideAllModals();
// });

// document
//   .getElementById("save-internship")
//   .addEventListener("click", function () {
//     const profile = document.getElementById("internship-profile").value;
//     const organization = document.getElementById(
//       "internship-organization"
//     ).value;
//     const location = document.getElementById("internship-location").value;
//     const startMonth = document.getElementById("internship-start-month").value;
//     const startYear = document.getElementById("internship-start-year").value;
//     const endMonth = document.getElementById("internship-end-month").value;
//     const endYear = document.getElementById("internship-end-year").value;
//     const description = document.getElementById("internship-description").value;

//     if (currentEditId) {
//       // Update existing internship
//       const element = document.getElementById(currentEditId);
//       element.querySelector(".entry-title").textContent = profile;
//       element.querySelector(
//         ".entry-subtitle"
//       ).textContent = `${organization}, ${location}`;
//       element.querySelector(
//         ".entry-date"
//       ).textContent = `Internship • ${startMonth} ${startYear} - ${endMonth} ${endYear}`;
//       element.querySelector(".entry-description").textContent = description;
//     } else {
//       // Add new internship
//       const experienceContainer = document.getElementById(
//         "experience-container"
//       );
//       const newInternship = document.createElement("div");
//       newInternship.className = "entry";
//       newInternship.id = "experience-" + Date.now();
//       newInternship.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-title">${profile}</div>
//                 <div class="entry-subtitle">${organization}, ${location}</div>
//                 <div class="entry-date">Internship • ${startMonth} ${startYear} - ${endMonth} ${endYear}</div>
//                 <div class="entry-description">${description}</div>
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="experience" data-id="${newInternship.id}">✏️</span>
//                 <span class="delete-icon" data-id="${newInternship.id}">🗑️</span>
//             </div>
//         `;
//       experienceContainer.appendChild(newInternship);

//       // Add event listeners to new buttons
//       newInternship
//         .querySelector(".edit-icon")
//         .addEventListener("click", function () {
//           const type = this.getAttribute("data-type");
//           const id = this.getAttribute("data-id");
//           currentEditId = id;
//           populateEditForm(type, id);
//           showModal(type);
//         });

//       newInternship
//         .querySelector(".delete-icon")
//         .addEventListener("click", function () {
//           const id = this.getAttribute("data-id");
//           if (confirm("Are you sure you want to delete this item?")) {
//             document.getElementById(id).remove();
//           }
//         });
//     }

//     hideAllModals();
//   });

// document.getElementById("save-project").addEventListener("click", function () {
//   const title = document.getElementById("project-title").value;
//   const startMonth = document.getElementById("project-start-month").value;
//   const startYear = document.getElementById("project-start-year").value;
//   const endMonth = document.getElementById("project-end-month").value;
//   const endYear = document.getElementById("project-end-year").value;
//   const url = document.getElementById("project-url").value;
//   const description = document.getElementById("project-description").value;

//   if (currentEditId) {
//     // Update existing project
//     const element = document.getElementById(currentEditId);
//     element.querySelector(".entry-title").textContent = title;
//     element.querySelector(
//       ".entry-date"
//     ).textContent = `${startMonth} ${startYear} - ${endMonth} ${endYear}`;

//     const projectLink = element.querySelector(".project-link");
//     if (url && !projectLink) {
//       // Add project link if it doesn't exist
//       const dateElement = element.querySelector(".entry-date");
//       const linkElement = document.createElement("a");
//       linkElement.href = url;
//       linkElement.className = "project-link";
//       linkElement.textContent = url;
//       dateElement.insertAdjacentElement("afterend", linkElement);
//     } else if (url && projectLink) {
//       // Update existing project link
//       projectLink.href = url;
//       projectLink.textContent = url;
//     } else if (!url && projectLink) {
//       // Remove project link if URL is empty
//       projectLink.remove();
//     }

//     element.querySelector(".entry-description").textContent = description;
//   } else {
//     // Add new project
//     const projectsContainer = document.getElementById("projects-container");
//     const newProject = document.createElement("div");
//     newProject.className = "entry";
//     newProject.id = "project-" + Date.now();
//     newProject.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-title">${title}</div>
//                 <div class="entry-date">${startMonth} ${startYear} - ${endMonth} ${endYear}</div>
//                 ${url ? `<a href="${url}" class="project-link">${url}</a>` : ""}
//                 <div class="entry-description">${description}</div>
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="project" data-id="${
//                   newProject.id
//                 }">✏️</span>
//                 <span class="delete-icon" data-id="${newProject.id}">🗑️</span>
//             </div>
//         `;
//     projectsContainer.appendChild(newProject);

//     // Add event listeners to new buttons
//     newProject
//       .querySelector(".edit-icon")
//       .addEventListener("click", function () {
//         const type = this.getAttribute("data-type");
//         const id = this.getAttribute("data-id");
//         currentEditId = id;
//         populateEditForm(type, id);
//         showModal(type);
//       });

//     newProject
//       .querySelector(".delete-icon")
//       .addEventListener("click", function () {
//         const id = this.getAttribute("data-id");
//         if (confirm("Are you sure you want to delete this item?")) {
//           document.getElementById(id).remove();
//         }
//       });
//   }

//   hideAllModals();
// });

// document.getElementById("save-skill").addEventListener("click", function () {
//   const skillName = document.getElementById("skill-name").value;

//   if (currentEditId) {
//     // Update existing skill
//     const element = document.getElementById(currentEditId);
//     element.querySelector("span").textContent = skillName;
//   } else {
//     // Add new skill
//     const skillsContainer = document.getElementById("skills-container");
//     const newSkill = document.createElement("div");
//     newSkill.className = "skill-item";
//     newSkill.id = "skill-" + Date.now();
//     newSkill.innerHTML = `
//             <span>${skillName}</span>
//             <span class="delete-icon" data-id="${newSkill.id}">🗑️</span>
//         `;
//     skillsContainer.appendChild(newSkill);

//     // Add event listener to new delete button
//     newSkill
//       .querySelector(".delete-icon")
//       .addEventListener("click", function () {
//         const id = this.getAttribute("data-id");
//         if (confirm("Are you sure you want to delete this skill?")) {
//           document.getElementById(id).remove();
//         }
//       });
//   }

//   hideAllModals();
// });

// document.getElementById("save-activity").addEventListener("click", function () {
//   const description = document.getElementById("activity-description").value;

//   if (currentEditId) {
//     // Update existing activity
//     const element = document.getElementById(currentEditId);
//     element.querySelector(".entry-description").textContent = description;
//   } else {
//     // Add new activity
//     const activitiesContainer = document.getElementById("activities-container");
//     const newActivity = document.createElement("div");
//     newActivity.className = "entry";
//     newActivity.id = "activity-" + Date.now();
//     newActivity.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-description">${description}</div>
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="activity" data-id="${newActivity.id}">✏️</span>
//                 <span class="delete-icon" data-id="${newActivity.id}">🗑️</span>
//             </div>
//         `;
//     activitiesContainer.appendChild(newActivity);

//     // Add event listeners to new buttons
//     newActivity
//       .querySelector(".edit-icon")
//       .addEventListener("click", function () {
//         const type = this.getAttribute("data-type");
//         const id = this.getAttribute("data-id");
//         currentEditId = id;
//         populateEditForm(type, id);
//         showModal(type);
//       });

//     newActivity
//       .querySelector(".delete-icon")
//       .addEventListener("click", function () {
//         const id = this.getAttribute("data-id");
//         if (confirm("Are you sure you want to delete this activity?")) {
//           document.getElementById(id).remove();
//         }
//       });
//   }

//   hideAllModals();
// });

// document.getElementById("save-training").addEventListener("click", function () {
//   const name = document.getElementById("training-name").value;
//   const organization = document.getElementById("training-organization").value;
//   const location = document.getElementById("training-location").value;
//   const startMonth = document.getElementById("training-start-month").value;
//   const startYear = document.getElementById("training-start-year").value;
//   const endMonth = document.getElementById("training-end-month").value;
//   const endYear = document.getElementById("training-end-year").value;
//   const description = document.getElementById("training-description").value;

//   if (currentEditId) {
//     // Update existing training
//     const element = document.getElementById(currentEditId);
//     element.querySelector(".entry-title").textContent = name;
//     element.querySelector(".entry-subtitle").textContent =
//       organization + (location ? `, ${location}` : "");
//     element.querySelector(
//       ".entry-date"
//     ).textContent = `${startMonth} ${startYear} - ${endMonth} ${endYear}`;

//     const descElement = element.querySelector(".entry-description");
//     if (description && !descElement) {
//       // Add description if it doesn't exist
//       const dateElement = element.querySelector(".entry-date");
//       const descDiv = document.createElement("div");
//       descDiv.className = "entry-description";
//       descDiv.textContent = description;
//       dateElement.insertAdjacentElement("afterend", descDiv);
//     } else if (description && descElement) {
//       // Update existing description
//       descElement.textContent = description;
//     } else if (!description && descElement) {
//       // Remove description if empty
//       descElement.remove();
//     }
//   } else {
//     // Add new training
//     const trainingContainer = document.getElementById("training-container");
//     const newTraining = document.createElement("div");
//     newTraining.className = "entry";
//     newTraining.id = "training-" + Date.now();
//     newTraining.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-title">${name}</div>
//                 <div class="entry-subtitle">${organization}${
//       location ? `, ${location}` : ""
//     }</div>
//                 <div class="entry-date">${startMonth} ${startYear} - ${endMonth} ${endYear}</div>
//                 ${
//                   description
//                     ? `<div class="entry-description">${description}</div>`
//                     : ""
//                 }
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="training" data-id="${
//                   newTraining.id
//                 }">✏️</span>
//                 <span class="delete-icon" data-id="${newTraining.id}">🗑️</span>
//             </div>
//         `;
//     trainingContainer.appendChild(newTraining);

//     // Add event listeners to new buttons
//     newTraining
//       .querySelector(".edit-icon")
//       .addEventListener("click", function () {
//         const type = this.getAttribute("data-type");
//         const id = this.getAttribute("data-id");
//         currentEditId = id;
//         populateEditForm(type, id);
//         showModal(type);
//       });

//     newTraining
//       .querySelector(".delete-icon")
//       .addEventListener("click", function () {
//         const id = this.getAttribute("data-id");
//         if (confirm("Are you sure you want to delete this training?")) {
//           document.getElementById(id).remove();
//         }
//       });
//   }

//   hideAllModals();
// });

// document
//   .getElementById("save-portfolio")
//   .addEventListener("click", function () {
//     const title = document.getElementById("portfolio-title").value;
//     const url = document.getElementById("portfolio-url").value;
//     const description = document.getElementById("portfolio-description").value;

//     if (currentEditId) {
//       // Update existing portfolio item
//       const element = document.getElementById(currentEditId);
//       element.querySelector(".entry-title").textContent = title;
//       element.querySelector(".project-link").href = url;
//       element.querySelector(".project-link").textContent = url;

//       const descElement = element.querySelector(".entry-description");
//       if (description && !descElement) {
//         // Add description if it doesn't exist
//         const linkElement = element.querySelector(".project-link");
//         const descDiv = document.createElement("div");
//         descDiv.className = "entry-description";
//         descDiv.textContent = description;
//         linkElement.insertAdjacentElement("afterend", descDiv);
//       } else if (description && descElement) {
//         // Update existing description
//         descElement.textContent = description;
//       } else if (!description && descElement) {
//         // Remove description if empty
//         descElement.remove();
//       }
//     } else {
//       // Add new portfolio item
//       const portfolioContainer = document.getElementById("portfolio-container");
//       const newPortfolio = document.createElement("div");
//       newPortfolio.className = "entry";
//       newPortfolio.id = "portfolio-" + Date.now();
//       newPortfolio.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-title">${title}</div>
//                 <a href="${url}" class="project-link">${url}</a>
//                 ${
//                   description
//                     ? `<div class="entry-description">${description}</div>`
//                     : ""
//                 }
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="portfolio" data-id="${
//                   newPortfolio.id
//                 }">✏️</span>
//                 <span class="delete-icon" data-id="${newPortfolio.id}">🗑️</span>
//             </div>
//         `;
//       portfolioContainer.appendChild(newPortfolio);

//       // Add event listeners to new buttons
//       newPortfolio
//         .querySelector(".edit-icon")
//         .addEventListener("click", function () {
//           const type = this.getAttribute("data-type");
//           const id = this.getAttribute("data-id");
//           currentEditId = id;
//           populateEditForm(type, id);
//           showModal(type);
//         });

//       newPortfolio
//         .querySelector(".delete-icon")
//         .addEventListener("click", function () {
//           const id = this.getAttribute("data-id");
//           if (confirm("Are you sure you want to delete this portfolio item?")) {
//             document.getElementById(id).remove();
//           }
//         });
//     }

//     hideAllModals();
//   });

// document
//   .getElementById("save-accomplishment")
//   .addEventListener("click", function () {
//     const description = document.getElementById(
//       "accomplishment-description"
//     ).value;

//     if (currentEditId) {
//       // Update existing accomplishment
//       const element = document.getElementById(currentEditId);
//       element.querySelector(".entry-description").textContent = description;
//     } else {
//       // Add new accomplishment
//       const accomplishmentsContainer = document.getElementById(
//         "accomplishments-container"
//       );
//       const newAccomplishment = document.createElement("div");
//       newAccomplishment.className = "entry";
//       newAccomplishment.id = "accomplishment-" + Date.now();
//       newAccomplishment.innerHTML = `
//             <div class="entry-content">
//                 <div class="entry-description">${description}</div>
//             </div>
//             <div class="entry-actions">
//                 <span class="edit-icon" data-type="accomplishment" data-id="${newAccomplishment.id}">✏️</span>
//                 <span class="delete-icon" data-id="${newAccomplishment.id}">🗑️</span>
//             </div>
//         `;
//       accomplishmentsContainer.appendChild(newAccomplishment);

//       // Add event listeners to new buttons
//       newAccomplishment
//         .querySelector(".edit-icon")
//         .addEventListener("click", function () {
//           const type = this.getAttribute("data-type");
//           const id = this.getAttribute("data-id");
//           currentEditId = id;
//           populateEditForm(type, id);
//           showModal(type);
//         });

//       newAccomplishment
//         .querySelector(".delete-icon")
//         .addEventListener("click", function () {
//           const id = this.getAttribute("data-id");
//           if (confirm("Are you sure you want to delete this accomplishment?")) {
//             document.getElementById(id).remove();
//           }
//         });
//     }

//     hideAllModals();
//   });

// Close modal when clicking outside
window.addEventListener("click", function (event) {
  if (event.target.classList.contains("modal-overlay")) {
    hideAllModals();
  }
});
