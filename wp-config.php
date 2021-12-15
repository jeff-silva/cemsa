<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'cemigsaude' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'root' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'g/A_YQs:*>]YlYCwiHWnQbVsk?+Weu$|2Ys~1N$,(jbbxPG#0t0<X:!;9?@w`]=L' );
define( 'SECURE_AUTH_KEY',  'A~y3kM)P|cC7>Zi{5HE6Io[y~?=Je$E?U]<~lBhIq]]7ec/_c}lY:f3>KKR:h~!d' );
define( 'LOGGED_IN_KEY',    'X^t Q145AB{J]KM%zyuvsI3)m.3i#k3S}7(8}V0`e{uo*hvAIA3uas/x^z,Y=&]Y' );
define( 'NONCE_KEY',        'teo){(HqS0sMMGUNv/d?Q<E`@gKW&ET)6A+#0w^vJRwSD*bY;lxgO[Z$I1dySZxs' );
define( 'AUTH_SALT',        'BdiC%6{Fu<r`|#js{OJCWopi,bU10__z4)%-(#9w{M}!]ULYM%fNS:*rp^&B&S*!' );
define( 'SECURE_AUTH_SALT', '+n/U8$WfZx{6X[`61-gJV8nNbzkdtI(:GaaB<;G/igL3FgHde*w$Sb25HyhL&+IY' );
define( 'LOGGED_IN_SALT',   '[|q$L_VVH0+v%R5H-0Vc`V,110bo/;>6&L f`:5VQp)G1YJ|D8L`j9{nt,D[VsL{' );
define( 'NONCE_SALT',       '~.l5Glo2D(7y4QLt.iNClDFD+m9@^4*1 WrohBHCH(Zo3m%&[b~f?v;AR%aO^>H^' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'site_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
