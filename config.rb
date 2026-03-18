# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "/"
http_stylesheets_dir = "css"
http_javascripts_dir = "js"
http_images_dir = "img"
http_fonts_dir = "fonts"

sass_dir = "app/webroot/css/src/"
css_dir = "app/webroot/css/build/"
javascripts_dir = "app/webroot/js/"
images_dir = "app/webroot/img/"
fonts_dir = "app/webroot/fonts/"

output_style = :compressed
environment = :production

relative_assets = false

line_comments = false
color_output = false

# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass app/webroot/css/src scss && rm -rf sass && mv scss sass
preferred_syntax = :scss

# Settings
Sass::Script::Number.precision = 10;

# Removes the BOM for UTF-8 stylesheets.
on_stylesheet_saved do |filename|
  css     = File.open(filename, 'r')
  content = css.read
  if "UTF-8" == content.encoding.name
    content.sub!("\xEF\xBB\xBF".force_encoding("UTF-8"), '')
    File.write(filename, content)
  end
end
