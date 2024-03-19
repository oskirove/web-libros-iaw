# PRÁCTICA FINAL
### Web de Aluguer e Venda de Libros e Comics

Este é a miña guía de implementación para a creación dun sitio web dedicado á xestión de aluguer e venda de libros e comics. A práctica foi desenvolvida usando PHP e MySQL para manexar a lóxica do lado do servidor e a almacenaxe de datos, respectivamente.

## Índice

- [Introdución](#introdución)
- [Configuración da Base de Datos](#configuración-da-base-de-datos)
- [Páxina de Inicio](#páxina-de-inicio)
- [Menú para Usuarios](#menú-para-usuarios)
- [Panel de Administradores](#panel-de-administradores)
- [Notas Adicionais](#notas-adicionais)

## Introdución

A nosa meta é deseñar unha plataforma intuitiva e segura onde os usuarios poidan alugar ou comprar libros e comics de maneira sinxela. Asegurámonos de que a navegación e a interfaz sexan amigables para todos os usuarios, incluíndo funcionalidades específicas tanto para usuarios xerais como para administradores.

## Configuración da Base de Datos

A base de datos `catalogo` é esencial para o noso proxecto. Seguimos estritamente as especificacións dadas para asegurarnos de que a nosa implementación é coherente e eficaz. Aquí detallamos a estrutura das táboas requeridas:

### Táboas

- **Táboa `usuario`**
  - `usuario` VARCHAR(24)
  - `contrasinal` VARCHAR(8)
  - `nome` VARCHAR(60)
  - `direccion` VARCHAR(90)
  - `telefono` INT
  - `nifdni` VARCHAR(9)
  - `tipo_usuario` CHAR(1)

- **Táboa `novo_rexistro`**
  - Campos idénticos á táboa `usuario`.

- **Táboa `libro_aluguer`**
  - `titulo` VARCHAR(80)
  - `cantidade` INT
  - `descripcion` VARCHAR(120)
  - `editorial` VARCHAR(24)
  - `prezo` INT
  - `foto` VARCHAR(1000)

- **Táboa `libro_alugado` e `libro_devolto`**
  - Campos idénticos á táboa `libro_aluguer` máis o campo `usuario`.

- **Táboa `libro_venda`**
  - Campos idénticos á táboa `libro_aluguer`.

### Notas sobre a Base de Datos

- Todas as `fotos` dos libros e comics representaranse como URLs.
- Pode ser necesario incluír campos ou táboas adicionais para unha implementación completa. Consultade co voso profesor para calquera modificación necesaria.

## Páxina de Inicio

O ficheiro `index.html` servirá como a porta de entrada ao noso sitio web, ofrecendo:

- Mensaxe de benvida.
- Formulario básico de autenticación.
- Opcións para "Acceder" ou "Rexistrarse".

## Menú para Usuarios

Unha vez autenticados, os usuarios terán acceso a diferentes funcionalidades:

- Listaxe de libros e comics en aluguer e venda.
- Modificación dos seus datos persoais.
- Procesos para alugar ou devolver un libro/comic.
- Capacidade para comprar e xerar un comprobante da compra.

## Panel de Administradores

O panel de administración inclúe funcionalidades específicas para a xestión do sitio, como:

- Admisión de novos usuarios.
- Xestión do catálogo de libros e comics (aluguer e venda).
- Informes sobre o estado actual do inventario.

## Notas Adicionais

- **Seguridade**: É crucial implementar medidas de seguridade adecuadas, especialmente na xestión de contrasinais e datos persoais dos usuarios.
- **Interfaz de Usuario**: Recomendamos dedicar tempo ao deseño da interfaz para garantir unha experiencia de usuario positiva.
- **Testing**: Antes do lanzamento, realizar probas exhaustivas para asegurar que todas as funcionalidades funcionen correctamente.

Con estes pasos e recomendacións, estamos preparados para desenvolver un sitio web funcional e atractivo para a venda e aluguer de libros e comics. ¡Mans á obra!
