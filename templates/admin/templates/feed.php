<script id="feedItem" type="text/template">

    <div class="laqm-item-image trigger-edit <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>"><% if (featured_image){%><img src="<%=featured_image%>"><%}%></div>

    <div class="laqm-item-info">
        <div class="laqm-item-title-tools">
            <div class="laqm-item-tools">
                <a class="laqm-btn laqm-btn-tools with-icon trigger-preview" data-id="<%=id%>" href="<%=preview_link%>" target="_blank"><span class="icon-ico-preview"></span></a>
                <a class="laqm-btn laqm-btn-tools with-icon trigger-edit" data-id="<%=id%>" href="javascript:void(0);"><span class="icon-ico-pen"></span></a>
                <% if (flag_main == 0){%>
                <a class="laqm-btn laqm-btn-tools with-icon trigger-delete" data-id="<%=id%>" href="javascript:void(0);"><span class="icon-ico-delete"></span></a>
                <% } %>
            </div>
            <div class="laqm-item-title no-item-title-image trigger-edit <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>">
                <% if (flag_published == 0){%><span class="draft-label">Draft</span>  <%}%><%=title%>
            </div>

        </div>
        <div class="laqm-item-stats pull-left">
            <div class="laqm-item-stat-value">Stories: <%=quizzes_count%> </div>
        </div>
        <div class="laqm-item-date-author pull-right">
            <%=date_added%> by <%=user_name%>
        </div>
        <div style="clear: both;"></div>
    </div>

</script>
<script id="feedQuizItem" type="text/template">
    <div class="col-sm-12">
        <div class="checkbox icheck-info">
            <input type="checkbox" checked id="quizz<%=id%>" />
            <label for="quizz<%=id%>"><%=title%></label>
        </div>
    </div>
</script>