module.exports = {
  entry: {
    app: ['./app/Resources/vuejs/css/app.scss', './app/Resources/vuejs/js/main.js']
  },
  port: 3003,
  html: false,
  assets_url: '/',  // Urls dans le fichier final
  assets_path: './web/dist/', // ou build ?
  refresh: ['src/**/*.php', 'app/Resources/views/**/*.twig'] // Permet de forcer le rafraichissement du navigateur lors de la modification de ces fichiers
}
