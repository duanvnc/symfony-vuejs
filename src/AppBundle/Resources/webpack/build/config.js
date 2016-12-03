module.exports = {
  entry: {
    app: ['./src/AppBundle/Resources/webpack/css/app.scss', './src/AppBundle/Resources/webpack/js/main.js']
  },
  port: 3003,
  html: false,
  assets_url: '/',  // Urls dans le fichier final
  assets_path: './web/dist/', // ou build ?
  refresh: ['src/**/*.php', 'app/Resources/views/**/*.twig', 'src/**/*.twig'] // Permet de forcer le rafraichissement du navigateur lors de la modification de ces fichiers
}
