{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>#seo_t_static_plugin_contact#]}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>#seo_d_static_plugin_contact#]}{/block}
{block name='body:id'}contact{/block}

{block name="article:content"}
    <h1>{#contact_root_h1#}</h1>
    <form id="contact-form" method="post" action="{$smarty.server.REQUEST_URI}" class="form-horizontal">
        <legend>{#contact_fiels_resquest#|ucfirst}</legend>
        <div class="form-group">
            <label class="col-md-3" for="nom">
                {#pn_contact_lastname#|ucfirst}* :
            </label>
            <div class="col-md-6">
                <input id="nom" type="text" name="nom" value="" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="prenom">
                {#pn_contact_firstname#|ucfirst}* :
            </label>
            <div class="col-md-6">
                <input id="prenom" type="text" name="prenom" value="" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="email">
                {#pn_contact_mail#|ucfirst}* :
            </label>
            <div class="col-md-6">
                <input id="email" type="text" name="email" value="" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="tel">
                {#pn_contact_phone#|ucfirst} :
            </label>
            <div class="col-md-6">
                <input id="tel" type="text" name="tel" value="" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="adresse">
                {#pn_contact_address#|ucfirst} :
            </label>
            <div class="col-md-6">
                <input id="adresse" type="text" name="adresse" value="" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="programme">
                {#pn_contact_programme#|ucfirst} :
            </label>
            <div class="col-md-6">
                <input id="programme" type="text" name="programme" value="{$smarty.post.moreinfo}" class="form-control"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3" for="programme">
                {#pn_contact_message#|ucfirst} :
            </label>
            <div class="col-md-6">
                <textarea id="message" name="message" rows="5" class="form-control" ></textarea>
            </div>
        </div>
        <div class="form-group">
            <p class="col-md-3">
                &nbsp;
            </p>
            <div class="col-md-6">
                <input id="getLanguage" type="hidden" name="getLanguage" value="{getlang}" />
                <input type="submit" class="btn btn-primary" value="{#pn_contact_send#|ucfirst}" />
            </div>
        </div>
    </form>
{/block}
{block name='aside:content' append}
    {widget_news_display
    conf    =   [
    'level' => 'last-news',
    'limit' => 3
    ]
    pattern = 'sidebar'
    prepend = "<h2 class='lead'>{#last_news#|ucfirst}</h2>"
    }
{/block}
{block name="foot" append}
    {script src="/min/?f=libjs/plugins/localization/messages_{getlang}.js,plugins/contact/js/public.0.3.js" concat=$concat type="javascript"}
    <script type="text/javascript">
        var iso = '{getlang}';
        $(function(){
            if (typeof MC_plugins_contact == "undefined")
            {
                console.log("MC_plugins_contact is not defined");
            }else{
                MC_plugins_contact.run(iso);
            }
        });
    </script>
{/block}
