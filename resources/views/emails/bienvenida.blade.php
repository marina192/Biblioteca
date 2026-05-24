<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bienvenido a {{ config('app.name', 'Biblioteca') }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        /* Reset */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; width: 100% !important; height: 100% !important; }

        /* Google Fonts import */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lora:ital,wght@0,400;0,500;1,400&display=swap');

        @keyframes softGlow {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .glow-text {
            animation: softGlow 3s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container { width: 100% !important; }
            .fluid-img { width: 100% !important; max-width: 600px !important; height: auto !important; }
            .stack-column { display: block !important; width: 100% !important; }
            .content-padding { padding: 20px 16px !important; }
            .header-title { font-size: 26px !important; }
            .feature-box { margin-bottom: 12px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #0a0e1a; font-family: 'Lora', Georgia, 'Times New Roman', serif;">

    <!-- Preheader Text (hidden, for email client preview) -->
    <div style="display: none; max-height: 0px; overflow: hidden; font-size: 1px; line-height: 1px; color: #0a0e1a;">
        ¡Bienvenido/a a {{ config('app.name', 'Biblioteca') }}, {{ $user->name }}! Tu aventura entre libros comienza ahora. Un mundo de historias te espera...
    </div>

    <!-- Main Wrapper -->
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #0a0e1a;">
        <tr>
            <td align="center" style="padding: 20px 10px;">

                <!-- Email Container -->
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="email-container" style="max-width: 600px; width: 100%; background-color: #0d1326; border-radius: 16px; overflow: hidden; box-shadow: 0 0 60px rgba(100, 149, 237, 0.15), 0 0 120px rgba(75, 0, 130, 0.08);">

                    <!-- ============================================ -->
                    <!-- HEADER - Hero Image -->
                    <!-- ============================================ -->
                    <tr>
                        <td style="position: relative;">
                            <img src="{{ asset('images/email/enchanted-forest-header.png') }}"
                                alt="Bosque encantado bajo la luz de la luna"
                                width="600"
                                class="fluid-img"
                                style="display: block; width: 100%; max-width: 600px; height: auto; border-radius: 16px 16px 0 0;">
                            <!-- Gradient Overlay simulado con imagen -->
                            <div style="background: linear-gradient(to bottom, transparent 40%, #0d1326 100%); position: absolute; bottom: 0; left: 0; right: 0; height: 80px;"></div>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- DECORATIVE SPARKLE DIVIDER -->
                    <!-- ============================================ -->
                    <tr>
                        <td align="center" style="padding: 0 40px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="border-bottom: 1px solid rgba(100, 149, 237, 0.2); padding-top: 0;">
                                        <div style="text-align: center; margin-bottom: -10px;">
                                            <span style="background-color: #0d1326; padding: 0 16px; color: #6eb3f5; font-size: 18px; letter-spacing: 8px;">✦ ✧ ✦</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- WELCOME TITLE -->
                    <!-- ============================================ -->
                    <tr>
                        <td class="content-padding" style="padding: 30px 40px 10px 40px; text-align: center;">
                            <h1 class="header-title" style="margin: 0; font-family: 'Cinzel', Georgia, serif; font-size: 32px; font-weight: 700; color: #c9daf8; letter-spacing: 3px; text-shadow: 0 0 20px rgba(100, 149, 237, 0.4);">
                                Bienvenido/a
                            </h1>
                            <p style="margin: 8px 0 0 0; font-family: 'Cinzel', Georgia, serif; font-size: 16px; color: #7b9fd4; letter-spacing: 6px; text-transform: uppercase;">
                                al bosque de los libros
                            </p>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- PERSONALIZED GREETING -->
                    <!-- ============================================ -->
                    <tr>
                        <td class="content-padding" style="padding: 20px 40px 10px 40px; text-align: center;">
                            <p style="margin: 0; font-family: 'Lora', Georgia, serif; font-size: 18px; color: #a8c4e0; line-height: 1.6;">
                                Querido/a
                            </p>
                            <p style="margin: 6px 0 0 0; font-family: 'Cinzel', Georgia, serif; font-size: 24px; font-weight: 600; color: #e8d5a3; letter-spacing: 2px; text-shadow: 0 0 15px rgba(232, 213, 163, 0.3);">
                                {{ $user->name }}
                            </p>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- MAIN MESSAGE -->
                    <!-- ============================================ -->
                    <tr>
                        <td class="content-padding" style="padding: 20px 40px 10px 40px;">
                            <p style="margin: 0; font-family: 'Lora', Georgia, serif; font-size: 15px; color: #8fa8c8; line-height: 1.8; text-align: center;">
                                Has cruzado el umbral de un lugar donde el tiempo se detiene y las historias cobran vida.
                                Como en un bosque antiguo y encantado, cada sendero aquí te llevará a mundos ocultos,
                                donde la imaginación respira y la magia habita entre las páginas.
                            </p>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- ENCHANTED DIVIDER IMAGE -->
                    <!-- ============================================ -->
                    <tr>
                        <td align="center" style="padding: 20px 40px;">
                            <img src="{{ asset('images/email/forest-divider.png') }}"
                                alt="Decoración de bosque encantado"
                                width="520"
                                class="fluid-img"
                                style="display: block; width: 100%; max-width: 520px; height: 120px; object-fit: cover; border-radius: 8px; opacity: 0.85;">
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- USER DATA CARD -->
                    <!-- ============================================ -->
                    <tr>
                        <td class="content-padding" style="padding: 10px 40px 20px 40px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background: linear-gradient(135deg, rgba(30, 42, 74, 0.8) 0%, rgba(20, 30, 56, 0.9) 100%); border: 1px solid rgba(100, 149, 237, 0.15); border-radius: 12px; overflow: hidden;">
                                <!-- Card Header -->
                                <tr>
                                    <td style="padding: 18px 24px 12px 24px; border-bottom: 1px solid rgba(100, 149, 237, 0.1);">
                                        <p style="margin: 0; font-family: 'Cinzel', Georgia, serif; font-size: 14px; color: #6eb3f5; letter-spacing: 3px; text-transform: uppercase; text-align: center;">
                                            ✦ Tu Pergamino de Registro ✦
                                        </p>
                                    </td>
                                </tr>
                                <!-- Name -->
                                <tr>
                                    <td style="padding: 16px 24px 8px 24px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="30" valign="top">
                                                    <span style="font-size: 18px;">📜</span>
                                                </td>
                                                <td style="padding-left: 10px;">
                                                    <p style="margin: 0; font-family: 'Lora', Georgia, serif; font-size: 12px; color: #6b8ab5; text-transform: uppercase; letter-spacing: 1px;">Nombre completo</p>
                                                    <p style="margin: 4px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 16px; color: #c9daf8; font-weight: 500;">{{ $user->name }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Email -->
                                <tr>
                                    <td style="padding: 12px 24px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="30" valign="top">
                                                    <span style="font-size: 18px;">🦉</span>
                                                </td>
                                                <td style="padding-left: 10px;">
                                                    <p style="margin: 0; font-family: 'Lora', Georgia, serif; font-size: 12px; color: #6b8ab5; text-transform: uppercase; letter-spacing: 1px;">Correo mágico</p>
                                                    <p style="margin: 4px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 16px; color: #c9daf8;">{{ $user->email }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Registration Date -->
                                <tr>
                                    <td style="padding: 8px 24px 16px 24px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="30" valign="top">
                                                    <span style="font-size: 18px;">🌙</span>
                                                </td>
                                                <td style="padding-left: 10px;">
                                                    <p style="margin: 0; font-family: 'Lora', Georgia, serif; font-size: 12px; color: #6b8ab5; text-transform: uppercase; letter-spacing: 1px;">Fecha de ingreso</p>
                                                    <p style="margin: 4px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 16px; color: #c9daf8;">{{ $user->created_at->translatedFormat('d \\d\\e F \\d\\e Y') }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- FEATURE BOXES -->
                    <!-- ============================================ -->
                    <tr>
                        <td class="content-padding" style="padding: 10px 40px 20px 40px;">
                            <p style="margin: 0 0 16px 0; font-family: 'Cinzel', Georgia, serif; font-size: 15px; color: #7b9fd4; letter-spacing: 2px; text-transform: uppercase; text-align: center;">
                                Lo que te espera
                            </p>

                            <!-- Feature 1: Catálogo -->
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="feature-box" style="margin-bottom: 12px;">
                                <tr>
                                    <td style="background: rgba(30, 42, 74, 0.5); border: 1px solid rgba(100, 149, 237, 0.1); border-radius: 10px; padding: 16px 20px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="44" valign="top">
                                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #1a2d5a, #2a4a8a); border-radius: 10px; text-align: center; line-height: 40px; font-size: 20px;">
                                                        📚
                                                    </div>
                                                </td>
                                                <td style="padding-left: 14px;">
                                                    <p style="margin: 0; font-family: 'Cinzel', Georgia, serif; font-size: 14px; font-weight: 600; color: #c9daf8;">Explora el Catálogo</p>
                                                    <p style="margin: 4px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 13px; color: #7b9fd4; line-height: 1.5;">Descubre cientos de títulos organizados por categorías mágicas. Cada libro es un portal a otro mundo.</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Feature 2: Préstamos -->
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="feature-box" style="margin-bottom: 12px;">
                                <tr>
                                    <td style="background: rgba(30, 42, 74, 0.5); border: 1px solid rgba(100, 149, 237, 0.1); border-radius: 10px; padding: 16px 20px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="44" valign="top">
                                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #2a1a4a, #4a2a7a); border-radius: 10px; text-align: center; line-height: 40px; font-size: 20px;">
                                                        🔮
                                                    </div>
                                                </td>
                                                <td style="padding-left: 14px;">
                                                    <p style="margin: 0; font-family: 'Cinzel', Georgia, serif; font-size: 14px; font-weight: 600; color: #c9daf8;">Solicita Préstamos</p>
                                                    <p style="margin: 4px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 13px; color: #7b9fd4; line-height: 1.5;">Lleva contigo los libros que desees. El bosque te confía sus tesoros para que los explores a tu ritmo.</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Feature 3: Categorías -->
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" class="feature-box">
                                <tr>
                                    <td style="background: rgba(30, 42, 74, 0.5); border: 1px solid rgba(100, 149, 237, 0.1); border-radius: 10px; padding: 16px 20px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td width="44" valign="top">
                                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #1a3a2a, #2a6a4a); border-radius: 10px; text-align: center; line-height: 40px; font-size: 20px;">
                                                        🌿
                                                    </div>
                                                </td>
                                                <td style="padding-left: 14px;">
                                                    <p style="margin: 0; font-family: 'Cinzel', Georgia, serif; font-size: 14px; font-weight: 600; color: #c9daf8;">Navega por Categorías</p>
                                                    <p style="margin: 4px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 13px; color: #7b9fd4; line-height: 1.5;">Cada sendero del bosque conduce a un rincón diferente. Encuentra tu género favorito entre la niebla.</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- CTA BUTTON -->
                    <!-- ============================================ -->
                    <tr>
                        <td align="center" style="padding: 10px 40px 30px 40px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="border-radius: 30px; background: linear-gradient(135deg, #1a3a6a 0%, #2a4a8a 50%, #3a2a7a 100%); box-shadow: 0 4px 20px rgba(100, 149, 237, 0.3), 0 0 40px rgba(100, 149, 237, 0.1);">
                                        <a href="{{ config('app.url') }}"
                                            target="_blank"
                                            style="display: inline-block; padding: 14px 40px; font-family: 'Cinzel', Georgia, serif; font-size: 14px; font-weight: 600; color: #e8d5a3; text-decoration: none; letter-spacing: 3px; text-transform: uppercase;">
                                            ✦ Entrar al Bosque ✦
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- INSPIRATIONAL QUOTE -->
                    <!-- ============================================ -->
                    <tr>
                        <td class="content-padding" style="padding: 0 40px 30px 40px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="border-top: 1px solid rgba(100, 149, 237, 0.15); border-bottom: 1px solid rgba(100, 149, 237, 0.15); padding: 20px 10px; text-align: center;">
                                        <p style="margin: 0; font-family: 'Lora', Georgia, serif; font-style: italic; font-size: 14px; color: #6b8ab5; line-height: 1.7;">
                                            "Un lector vive mil vidas antes de morir.<br>
                                            El que nunca lee vive solo una."
                                        </p>
                                        <p style="margin: 8px 0 0 0; font-family: 'Cinzel', Georgia, serif; font-size: 11px; color: #4a6a8a; letter-spacing: 2px;">
                                            — GEORGE R.R. MARTIN
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- ============================================ -->
                    <!-- FOOTER -->
                    <!-- ============================================ -->
                    <tr>
                        <td style="background: linear-gradient(to bottom, #0d1326, #080b16); padding: 24px 40px; border-top: 1px solid rgba(100, 149, 237, 0.08);">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0; font-family: 'Cinzel', Georgia, serif; font-size: 16px; color: #4a6a8a; letter-spacing: 4px;">
                                            🌙 {{ config('app.name', 'Biblioteca') }} 🌙
                                        </p>
                                        <p style="margin: 10px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 12px; color: #3a5070; line-height: 1.6;">
                                            Este correo fue enviado a <span style="color: #6b8ab5;">{{ $user->email }}</span>
                                            <br>porque te registraste en nuestro sistema de biblioteca.
                                        </p>
                                        <p style="margin: 12px 0 0 0; font-family: 'Lora', Georgia, serif; font-size: 11px; color: #2a3a50;">
                                            {{ config('app.url') }}
                                        </p>
                                        <p style="margin: 10px 0 0 0; font-size: 10px; color: #1a2a40; letter-spacing: 6px;">
                                            ✧ ✦ ✧ ✦ ✧
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
                <!-- End Email Container -->

            </td>
        </tr>
    </table>
    <!-- End Main Wrapper -->

</body>
</html>