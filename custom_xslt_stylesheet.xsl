<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE xsl:stylesheet>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:hostcms="http://www.hostcms.ru/"
                exclude-result-prefixes="hostcms">

    <xsl:output xmlns="http://www.w3.org/TR/xhtml1/strict" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" encoding="utf-8" indent="yes" method="html" omit-xml-declaration="no" version="1.0" media-type="text/xml"/>

    <!-- ФинансыСписокУслуг -->

    <xsl:template match="/informationsystem">
        <xsl:variable name="group" select="group"/>

        <xsl:if test="group=0">
            <xsl:if test="@id != 57 or @id != 56 or @id != 55 or @id != 54">
                <section class="main-home">
                    <div class="container">
                        <xsl:if test="count(informationsystem_group)">
                            <div class="row">
                                <xsl:apply-templates select="informationsystem_group[active=1]"/>
                            </div>
                        </xsl:if>
                    </div>
                </section>
            </xsl:if>
        </xsl:if>
        <xsl:if test="group!=0">
            <xsl:if test="group=12 or group=13 or group=14">
                <xsl:if test="informationsystem_item[@id != 324]">
                    <xsl:if test="informationsystem_item[@id != 325]">
                        <xsl:if test="informationsystem_item[@id != 492]">
                            <xsl:if test="informationsystem_item[@id != 493]">
                                <div class="container">
                                    <div class="row">
                                        <h2 class="light">Программы курса</h2>
                                    </div>
                                </div>
                            </xsl:if>
                        </xsl:if>
                    </xsl:if>
                </xsl:if>
            </xsl:if>
            <xsl:if test="group=15 or group=16">
                <section>
                    <div class="container">
                    </div>
                </section>
            </xsl:if>
            <xsl:if test="group!=12 and group!=13 and group!=11 and group!=14 and group!=15 and group!=16">
                <section>
                    <div class="container">
                        <header>
                            <h2><xsl:value-of disable-output-escaping="yes" select="informationsystem_group/name"/></h2>
                            <div class="separator-small"></div>
                        </header>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                            <div class="row">
                                <div class="group-description">
                                    <xsl:value-of disable-output-escaping="yes" select="informationsystem_group/description"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </xsl:if>
        </xsl:if>
        <xsl:if test="group!=0">
            <section>
                <xsl:if test="count(informationsystem_item)">
                    <xsl:if test="group=11">
                        <xsl:apply-templates select="informationsystem_item[active=1]"/>
                        <div class="clearfix"></div>
                    </xsl:if>
                    <xsl:if test="group!=11">
                        <div class="container">
                            <div class="row">
                                <xsl:if test="group!=12 and group!=13 and group!=14 and group!=15 and group!=16">
                                    <xsl:apply-templates select="informationsystem_item[active=1]"/>
                                </xsl:if>
                                <xsl:if test="group=12 or group=13 or group=14 or group=15 or group=16">
                                    <xsl:apply-templates select="informationsystem_item[active=1]" mode="office"/>
                                </xsl:if>
                            </div>
                        </div>
                    </xsl:if>
                </xsl:if>
            </section>
        </xsl:if>
    </xsl:template>

    <xsl:template match="informationsystem_group">
        <div class="col-xs-12 col-md-6">
            <div class="service-group">
                <a class="service-item-image" href="{url}">
                    <img alt="{name}" src="{dir}{image_small}" />
                    <xsl:if test="property_value[tag_name='icon']/value != ''">
                        <div class="corner-ribbon top-left sticky blue shadow">
                            <xsl:attribute name="class">corner-ribbon top-left sticky shadow color-<xsl:value-of select="position()"/></xsl:attribute>
                            <xsl:value-of disable-output-escaping="yes" select="property_value[tag_name='icon']/value"/>
                        </div>
                    </xsl:if>
                    <xsl:if test="position() = 1">
                        <div class="voxy-logo"><img src="/i/voxy_l.png" /></div>
                    </xsl:if>
                </a>
                <div class="service-item-content">
                    <h3><a href="{url}"><xsl:value-of disable-output-escaping="yes" select="name"/></a></h3>
                    <!-- <xsl:value-of disable-output-escaping="yes" select="description"/> -->
                    <div class="price-button">
                        <div class="price">
                            <xsl:value-of disable-output-escaping="yes" select="property_value[tag_name='price']/value"/>
                        </div>
                        <a class="btn btn-transparent" href="{url}">Узнать больше</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </xsl:template>
    <xsl:template match="informationsystem_item">
        <div class="col-xs-12 col-md-6">
            <xsl:attribute name="class">
                <xsl:if test="@id=330 or @id=334">voxy-item</xsl:if>
                <xsl:if test="@id!=330 and @id!=334">col-xs-12 col-md-6</xsl:if>
            </xsl:attribute>

            <xsl:if test="@id!=330 and @id!=334">
                <h3><xsl:value-of disable-output-escaping="yes" select="name"/></h3>
                <div class="service-item">
                    <div class="service-item-content">
                        <xsl:value-of disable-output-escaping="yes" select="description"/>

                        <div class="price">
                            <xsl:value-of disable-output-escaping="yes" select="property_value[tag_name='price']/value"/>
                        </div>
                    </div>
                    <xsl:if test="/informationsystem[@id != 15]">
                        <section class="button-sec left">
                            <div><a class="btn btn-lightred" href="#freeDemo" data-toggle="modal">Заказать <strong>бесплатное демо</strong></a></div>
                        </section>
                    </xsl:if>
                </div>
            </xsl:if>

            <xsl:if test="@id=330">
                <!-- <div class="container">
                    <h3><xsl:value-of disable-output-escaping="yes" select="name"/></h3>
                </div>-->
                <xsl:value-of disable-output-escaping="yes" select="description"/>
                <!-- <section class="button-sec">
            <div><a class="btn btn-lightred" href="#freeDemo" data-toggle="modal">Заказать <strong>бесплатное демо</strong></a></div>
                </section>-->
            </xsl:if>

            <xsl:if test="@id=334">
                <div class="container">
                    <xsl:value-of disable-output-escaping="yes" select="description"/>
                    <section class="button-sec">
                        <div class="service-item-content">
                            <div class="price">
                                <xsl:value-of disable-output-escaping="yes" select="property_value[tag_name='price']/value"/>
                            </div>
                        </div>
                        <div><a class="btn btn-lightred" href="#freeDemo" data-toggle="modal">Заказать <strong>бесплатное демо</strong></a></div>
                    </section>
                </div>
            </xsl:if>
            <div class="clearfix"></div>
        </div>
        <xsl:if test="position() mod2 = 0">
            <div class="clearfix"></div>
        </xsl:if>
    </xsl:template>
    <xsl:template match="informationsystem_item" mode="office">
        <div class="program-item">
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <h3><xsl:value-of disable-output-escaping="yes" select="name"/></h3>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="service-item">
                        <div class="service-item-content">
                            <xsl:value-of disable-output-escaping="yes" select="description"/>

                            <div class="price">
                                <xsl:value-of disable-output-escaping="yes" select="property_value[tag_name='price']/value"/>
                            </div>
                        </div>
                        <xsl:if test="/informationsystem[@id != 15]">
                            <section class="button-sec left">
                                <div><a class="btn btn-lightred" href="#freeDemo" data-toggle="modal">Заказать <strong>бесплатное демо</strong></a></div>
                            </section>
                        </xsl:if>
                    </div>
                </div>
            </div>
        </div>
    </xsl:template>

    <!-- Цикл для вывода строк ссылок -->
    <xsl:template name="for">
        <xsl:param name="i" select="0"/>
        <xsl:param name="prefix">page</xsl:param>
        <xsl:param name="link"/>
        <xsl:param name="limit"/>
        <xsl:param name="page"/>
        <xsl:param name="items_count"/>
        <xsl:param name="visible_pages"/>

        <xsl:variable name="n" select="$items_count div $limit"/>

        <!-- Заносим в переменную $group идентификатор текущей группы -->
        <xsl:variable name="group" select="/informationsystem/group"/>

        <!-- Считаем количество выводимых ссылок перед текущим элементом -->
        <xsl:variable name="pre_count_page">
            <xsl:choose>
                <xsl:when test="$page &gt; ($n - (round($visible_pages div 2) - 1))">
                    <xsl:value-of select="$visible_pages - ($n - $page)"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="round($visible_pages div 2) - 1"/>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:variable>

        <!-- Считаем количество выводимых ссылок после текущего элемента -->
        <xsl:variable name="post_count_page">
            <xsl:choose>
                <xsl:when test="0 &gt; $page - (round($visible_pages div 2) - 1)">
                    <xsl:value-of select="$visible_pages - $page"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:choose>
                        <xsl:when test="round($visible_pages div 2) = ($visible_pages div 2)">
                            <xsl:value-of select="$visible_pages div 2"/>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:value-of select="round($visible_pages div 2) - 1"/>
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:variable>

        <xsl:variable name="filter"><xsl:if test="/informationsystem/sorting/node()">?sorting=<xsl:value-of select="/informationsystem/sorting"/></xsl:if></xsl:variable>

        <xsl:if test="$items_count &gt; $limit and $n &gt; $i">

            <!-- Определяем адрес тэга -->
            <xsl:variable name="tag_link">
                <xsl:choose>
                    <!-- Если не нулевой уровень -->
                    <xsl:when test="count(/informationsystem/tag) != 0">tag/<xsl:value-of select="/informationsystem/tag/urlencode"/>/</xsl:when>
                    <!-- Иначе если нулевой уровень - просто ссылка на страницу со списком элементов -->
                    <xsl:otherwise></xsl:otherwise>
                </xsl:choose>
            </xsl:variable>

            <!-- Определяем адрес ссылки -->
            <xsl:variable name="number_link">
                <xsl:choose>
                    <!-- Если не нулевой уровень -->
                    <xsl:when test="$i != 0">
                        <xsl:value-of select="$prefix"/>-<xsl:value-of select="$i + 1"/>/</xsl:when>
                    <!-- Иначе если нулевой уровень - просто ссылка на страницу со списком элементов -->
                    <xsl:otherwise></xsl:otherwise>
                </xsl:choose>
            </xsl:variable>

            <!-- Ставим ссылку на страницу-->
            <xsl:if test="$i != $page">
                <!-- Выводим ссылку на первую страницу -->
                <xsl:if test="$page - $pre_count_page &gt; 0 and $i = 0">
                    <li><a href="{$link}{$filter}">&#x2190;</a></li>
                </xsl:if>

                <xsl:choose>
                    <xsl:when test="$i &gt;= ($page - $pre_count_page) and ($page + $post_count_page) &gt;= $i">
                        <!-- Выводим ссылки на видимые страницы -->
                        <li><a href="{$link}{$tag_link}{$number_link}{$filter}">
                            <xsl:value-of select="$i + 1"/>
                        </a></li>
                    </xsl:when>
                    <xsl:otherwise></xsl:otherwise>
                </xsl:choose>

                <!-- Выводим ссылку на последнюю страницу -->
                <xsl:if test="$i+1 &gt;= $n and $n &gt; ($page + 1 + $post_count_page)">
                    <xsl:choose>
                        <xsl:when test="$n &gt; round($n)">
                            <!-- Выводим ссылку на последнюю страницу -->
                            <li><a href="{$link}{$prefix}-{round($n+1)}/{$filter}">→</a></li>
                        </xsl:when>
                        <xsl:otherwise>
                            <li><a href="{$link}{$prefix}-{round($n)}/{$filter}">→</a></li>
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:if>
            </xsl:if>

            <!-- Ссылка на предыдущую страницу для Ctrl + влево -->
            <xsl:if test="$page != 0 and $i = $page">
                <xsl:variable name="prev_number_link">
                    <xsl:choose>
                        <!-- Если не нулевой уровень -->
                        <xsl:when test="($page) != 0">page-<xsl:value-of select="$i"/>/</xsl:when>
                        <!-- Иначе если нулевой уровень - просто ссылка на страницу со списком элементов -->
                        <xsl:otherwise></xsl:otherwise>
                    </xsl:choose>
                </xsl:variable>

                <li class="hidden"><a href="{$link}{$tag_link}{$prev_number_link}{$filter}" id="id_prev"></a></li>
            </xsl:if>

            <!-- Ссылка на следующую страницу для Ctrl + вправо -->
            <xsl:if test="($n - 1) > $page and $i = $page">
                <li class="hidden"><a href="{$link}{$tag_link}page-{$page+2}/{$filter}" id="id_next"></a></li>
            </xsl:if>

            <!-- Не ставим ссылку на страницу-->
            <xsl:if test="$i = $page">
                <li class="active">
                    <a href="#"><xsl:value-of select="$i+1"/></a>
                </li>
            </xsl:if>

            <!-- Рекурсивный вызов шаблона. НЕОБХОДИМО ПЕРЕДАВАТЬ ВСЕ НЕОБХОДИМЫЕ ПАРАМЕТРЫ! -->
            <xsl:call-template name="for">
                <xsl:with-param name="i" select="$i + 1"/>
                <xsl:with-param name="prefix" select="$prefix"/>
                <xsl:with-param name="link" select="$link"/>
                <xsl:with-param name="limit" select="$limit"/>
                <xsl:with-param name="page" select="$page"/>
                <xsl:with-param name="items_count" select="$items_count"/>
                <xsl:with-param name="visible_pages" select="$visible_pages"/>
            </xsl:call-template>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>