
$(document).ready(function() {
  $("#add-book-form").validate({
    rules: {
      bookTitle: { required: true },
      bookDescription: { required: true },
      bookUniversity: { required: true },
      bookFile: { required: true },
      bookAuthor: { required: true },
      bookCover: { required: true },
      bookDepartment: { required: true }
    },
    messages: {
      bookTitle: "Veuillez entrer le titre du livre.",
      bookDescription: "Veuillez entrer la description du livre.",
      bookUniversity: "Veuillez entrer le nom de l'université.",
      bookFile: "Veuillez télécharger le fichier.",
      bookAuthor: "Veuillez entrer le nom de l'auteur.",
      bookCover: "Veuillez télécharger la couverture.",
      bookDepartment: "Veuillez entrer la filière."
    },
    submitHandler: function(form) {
      $.ajax({
        type: "POST",
        url: "add_book.php",
        data: new FormData(form),
        contentType: false,
        processData: false,
        success: function(response) {
          // Gérez la réponse du serveur ici
          console.log(response);
        },
        error: function(xhr, status, error) {
          // Gérez les erreurs ici
          console.error(error);
        }
      });
    }
  });
});
