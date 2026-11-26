<?xml version="1.0" encoding="UTF-8"?>
<!--
  XSLT: turns menu.xml into a printable HTML menu.

  Two ways it is used:
    1. Open data/menu.xml in the browser. The line
       <?xml-stylesheet type="text/xsl" href="menu.xsl"?> makes the BROWSER apply it.
    2. print_menu.php applies it on the SERVER with PHP's XSLTProcessor.

  Things to notice:  xsl:template, xsl:value-of, xsl:for-each, xsl:sort,
                     xsl:if, xsl:apply-templates, count(), format-number()
-->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <!-- Runs once, for the root <menu> element -->
  <xsl:template match="/menu">
    <html>
      <head>
        <meta charset="UTF-8"/>
        <title><xsl:value-of select="@shop"/> - Printable Menu</title>
        <style>
          body  { font-family: Georgia, serif; max-width: 640px; margin: 40px auto; padding: 0 16px; color: #2b1d14; background: #fbf7f2; }
          h1    { text-align: center; letter-spacing: 2px; margin-bottom: 0; }
          .sub  { text-align: center; color: #7a5c45; margin-top: 4px; }
          h2    { border-bottom: 2px solid #c49a6c; padding-bottom: 4px; margin-top: 32px; }
          .row  { display: flex; justify-content: space-between; gap: 12px; padding: 8px 0; border-bottom: 1px dotted #d8c3ad; }
          .desc { color: #7a5c45; font-size: 0.9em; }
          .tag  { font-size: 0.75em; background: #e9dccd; border-radius: 4px; padding: 1px 6px; margin-left: 6px; }
          .foot { text-align: center; color: #7a5c45; margin-top: 32px; font-size: 0.9em; }
        </style>
      </head>
      <body>
        <h1><xsl:value-of select="@shop"/></h1>
        <p class="sub">Prices in <xsl:value-of select="@currency"/></p>

        <!-- WAY 1: for-each, sorted by price (cheapest first) -->
        <h2>Drinks</h2>
        <xsl:for-each select="item[@type='drink']">
          <xsl:sort select="price" data-type="number" order="ascending"/>
          <div class="row">
            <div>
              <strong><xsl:value-of select="name"/></strong>
              <xsl:if test="hot = 'true'"><span class="tag">hot</span></xsl:if>
              <xsl:if test="hot = 'false'"><span class="tag">iced</span></xsl:if>
              <div class="desc"><xsl:value-of select="description"/></div>
            </div>
            <div><xsl:value-of select="format-number(price, '#,###')"/></div>
          </div>
        </xsl:for-each>

        <!-- WAY 2: apply-templates, sorted by name (A to Z) -->
        <h2>Food</h2>
        <xsl:apply-templates select="item[@type='food']">
          <xsl:sort select="name"/>
        </xsl:apply-templates>

        <p class="foot">
          <xsl:value-of select="count(item)"/> items on the menu
          (<xsl:value-of select="count(item[@type='drink'])"/> drinks,
          <xsl:value-of select="count(item[@type='food'])"/> food).
        </p>
      </body>
    </html>
  </xsl:template>

  <!-- Runs once for every food <item> chosen by apply-templates above -->
  <xsl:template match="item">
    <div class="row">
      <div>
        <strong><xsl:value-of select="name"/></strong>
        <xsl:if test="vegetarian = 'true'"><span class="tag">vegetarian</span></xsl:if>
        <div class="desc"><xsl:value-of select="description"/></div>
      </div>
      <div><xsl:value-of select="format-number(price, '#,###')"/></div>
    </div>
  </xsl:template>

</xsl:stylesheet>
