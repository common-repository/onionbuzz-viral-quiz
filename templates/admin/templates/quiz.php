<script id="quizItem" type="text/template">
        <div class="laqm-item-image trigger-edit <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>" <% if (featured_image){%>style="background-image: url('<%=featured_image%>');"<%}%>></div>
        <div class="laqm-item-info ">
            <div class="laqm-item-title-tools">
                <div class="laqm-item-tools">
                    <a class="laqm-btn laqm-btn-tools with-icon trigger-preview" data-id="<%=id%>" href="<%=preview_link%>" target="_blank"><span class="icon-ico-preview"></span></a>
                    <a class="laqm-btn laqm-btn-tools trigger-shortcode" data-id="<%=id%>" href="javascript:void(0);"><span>Shortcode</span></a>
                    <% if(type == 1 || type == 2 || type == 5) { %>
                    <a class="laqm-btn laqm-btn-tools with-icon trigger-stats buy-pro-version2" data-id="<%=id%>" href="javascript:void(0);"><span class="icon-ico-stats"></span></a>
                    <% } %>
                    <a class="laqm-btn laqm-btn-tools with-icon trigger-clone" data-id="<%=id%>" href="javascript:void(0);"><span class="icon-ico-clone"></span></a>
                    <a class="laqm-btn laqm-btn-tools with-icon trigger-edit" data-id="<%=id%>" href="javascript:void(0);"><span class="icon-ico-pen"></span></a>
                    <a class="laqm-btn laqm-btn-tools with-icon trigger-delete" data-id="<%=id%>" data-toggle="confirmation" data-singleton="true" href="javascript:void(0);"><span class="icon-ico-delete"></span></a>
                </div>
                <div class="laqm-item-title-image <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>"" >
                    <% if (type == 1){%>
                        <span class="icon-story-trivia"></span>
                    <%}%>
                    <% if (type == 2){%>
                        <span class="icon-story-personality"></span>
                    <%}%>
                    <% if (type == 3){%>
                    <span class="icon-story-list"></span>
                    <%}%>
                    <% if (type == 4){%>
                    <span class="icon-story-flip"></span>
                    <%}%>
                    <% if (type == 5){%>
                    <span class="icon-story-checklist"></span>
                    <%}%>
                </div>
                <div class="laqm-item-title trigger-edit <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>">
                    <% if (flag_published == 0){%><span class="draft-label">Draft</span> <%}%><%=title%>
                </div>

            </div>
            <div class="laqm-item-stats pull-left">
                <% if(type == 1 || type == 2 || type == 5) { %>
                <div class="laqm-item-stat-value"><a href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<%=id%>">Questions: <%=questions_count%></a> <% if (questions_count == 0){%><span>(!)</span><% } %></div>
                <div class="laqm-item-stat-value"><a href="?page=la_onionbuzz_dashboard&tab=quiz_results&quiz_id=<%=id%>">Results: <%=results_count%></a> <% if (results_count == 0){%><span>(!)</span><% } %></div>
                <% } %>
                <% if(type == 3 || type == 4) { %>
                <div class="laqm-item-stat-value"><a href="?page=la_onionbuzz_dashboard&tab=quiz_questions&quiz_id=<%=id%>">Items: <%=questions_count%></a> <% if (questions_count == 0){%><span>(!)</span><% } %></div>
                <% } %>
                <div class="laqm-item-stat-value">Feeds: <%=feeds_count%> </div>
                <% if(type == 1 || type == 2 || type == 5) { %>
                <div class="laqm-item-stat-value">Views: <%=views_count%> </div>
                <% } else {%>
                <div class="laqm-item-stat-value">Views: <%=views_count%> </div>
                <% } %>
            </div>
            <div class="laqm-item-stats pull-right">
                <div class="laqm-item-stat-value">ID: <%=id%> </div>
                <div class="laqm-item-stat-value"><%=date_added%> by <%=user_name%> </div>
            </div>
            <div class="laqm-item-date-author pull-right">
            </div>
            <div style="clear: both;"></div>
        </div>


</script>

<script id="quizResultItem" type="text/template">
    <div class="laqm-item-info">
        <div class="laqm-item-title-tools">
            <div class="laqm-item-tools">
                <a class="laqm-btn laqm-btn-tools with-icon trigger-edit" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" href="javascript:void(0);"><span class="icon-ico-pen"></span></a>
                <a class="laqm-btn laqm-btn-tools with-icon trigger-delete" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" href="javascript:void(0);"><span class="icon-ico-delete"></span></a>
            </div>
            <div class="laqm-item-title col-sm-3 trigger-edit <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>">
                <% if (flag_published == 0){%><span class="draft-label">Draft</span> <%}%><%=title%>
            </div>
            <div class="laqm-item-text col-sm-2 col-md-offset-1 <%=(flag_published == 0)?'drafted-item':'conditions'+id+'" data-index="'+indx+'"'%> >
                <% if(quiz_type == 1) {%>
            Correct score: <%=(conditions != 0)?'':''%><span class="condition-from"><%=condition_less%></span> - <span class="condition-to"><%=conditions%></span>%
                <% } %>
                <% if(quiz_type == 5) {%>
            Selected answers: <%=(conditions != 0)?'':''%><span class="condition-from"><%=condition_less%></span> - <span class="condition-to"><%=conditions%></span>%
                <% } %>

                <% if(quiz_type == 2) {%>

                <% } %>
            </div>

            <% if((quiz_type == 1 || quiz_type == 5) && flag_published == 1) {%>
            <div class="laqm-item-conditions-slider col-sm-4">
                <div class="flat-slider" data-id="<%=id%>" data-from="<%=condition_less%>" data-to="<%=conditions%>" style="width:100%;"></div>
            </div>
            <% } %>
        </div>
        <div style="clear: both;"></div>
    </div>
</script>
<script id="quizQuestionItem" type="text/template">
    <div class="laqm-item-image trigger-edit <%=(flag_publish == 0)?'drafted-item':''%>" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" data-editinline="<% if(quiz_type == 3 || quiz_type == 4) { %>1<% } else { %>0<% } %>" <% if (featured_image){%>style="background-image: url('<%=featured_image%>');"<%}%>></div>

    <div class="laqm-item-info" data-id="<%=id%>" data-position="0">
        <div class="laqm-item-title-tools">
            <div class="laqm-item-tools">
                <a class="laqm-btn laqm-btn-tools with-icon laqm-item-drag" href="javascript:void(0);"><span class="icon-ico-drag"></span></a>
                <a class="laqm-btn laqm-btn-tools with-icon trigger-edit" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" data-editinline="<% if(quiz_type == 3 || quiz_type == 4) { %>1<% } else { %>0<% } %>" href="javascript:void(0);"><span class="icon-ico-pen"></span></a>
                <a class="laqm-btn laqm-btn-tools with-icon trigger-delete" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" href="javascript:void(0);"><span class="icon-ico-delete"></span></a>
            </div>
            <div class="laqm-item-title no-item-title-image trigger-edit <%=(flag_publish == 0)?'drafted-item':''%>" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>">
                <% if (flag_publish == 0){%><span class="draft-label">Draft</span> <%}%><%=title%>
            </div>

        </div>
        <div class="laqm-item-stats pull-left">
            <% if(quiz_type != 3 && quiz_type != 4) { %>
                <% if(answers_type == "match") { %>
                    <div class="laqm-item-stat-value">Answers: <%=answers_count%> <% if (answers_count == 0){%><span>(!)</span><% } %></div>
                <% } else {%>
                    <div class="laqm-item-stat-value"><a href="?page=la_onionbuzz_dashboard&tab=quiz_question_answers&question_id=<%=id%>&quiz_id=<%=quiz_id%>">Answers: <%=answers_count%></a> <% if (answers_count == 0){%><span>(!)</span><% } %></div>
                <% } %>
            <% } %>
            <% if(quiz_type == 3 || quiz_type == 4) { %>
            <div class="laqm-item-stat-value"><a href="javascript:void(0);"></a></div>

            <% } %>
            <% if(quiz_type == 1) { %>
            <div class="laqm-item-stat-value">Correct: <%=correct_count%> <% if (correct_count == 0){%><span>(!)</span><% } %></div>
            <% } %>
        </div>
        <% if(quiz_type == 3 || quiz_type == 4) { %>
        <div style="clear: both;"></div>
        <div class="laqm-item-form" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>">
            <div class="container-add-form" data-question-id="<%=id%>" style="display: none;">
                <form class="form-horizontal form-ays">
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Published</label>
                        <div class="col-sm-3">
                            <div class="switch">
                                <input id="question_published" name="question_published" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" value="0">
                                <label for="question_published" data-on="Yes" data-off="No"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Title</label>
                        <div class="col-sm-9">
                            <input name="question_title" type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Description</label>
                        <div class="col-sm-9">
                            <textarea name="question_description" type="text" class="form-control" style="height: 150px;"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image<p class="help-block">Min width depends on your theme's page width</p></label>
                        <div class="col-sm-9">
                            <a class="laqm-item-image-add media_selector" href="javascript:void(0);" data-form=""></a>
                            <input name="featured_image" value="" type="hidden">
                            <input name="attachment_id" value="" type="hidden">
                            <a class="remove-featured-image-ajaxform" href="javascript:void(0);">Remove</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label-left">Image caption</label>
                        <div class="col-sm-9">
                            <input name="question_image_caption" type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <a class="laqm-btn laqm-btn-green pull-right submit-add-form" data-question-id="0" href="javascript:void(0);">Save</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <% } %>
        <div style="clear: both;"></div>
    </div>
    <% if(flag_pagebreak == 1){%>
    <div class="laqm-page-break">Page Break</div>
    <% } %>
</script>
<script id="quizQuestionAnswerItem" type="text/template">
    <div class="laqm-item-image trigger-edit <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" data-question_id="<%=question_id%>" <% if (featured_image){%>style="background-image: url('<%=featured_image%>');"<%}%>></div>
    <div class="laqm-item-info ">
        <div class="laqm-item-title-tools green-<%=flag_correct%>">
            <div class="laqm-item-tools">
                <a class="laqm-btn laqm-btn-tools with-icon trigger-edit" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" data-question_id="<%=question_id%>" href="javascript:void(0);"><span class="icon-ico-pen"></span></a>
                <a class="laqm-btn laqm-btn-tools with-icon trigger-delete" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" data-question_id="<%=question_id%>" href="javascript:void(0);"><span class="icon-ico-delete"></span></a>
            </div>
            <div class="laqm-item-title col-sm-3 trigger-edit <%=(flag_published == 0)?'drafted-item':''%>" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>" data-question_id="<%=question_id%>">
                <% if (flag_published == 0){%><span class="draft-label">Draft</span>  <%}%><%=title%>
            </div>

        </div>
        <div style="clear: both;"></div>
    </div>
</script>
<script id="quizStatsPlayerItem" type="text/template">
    <div class="laqm-item-info">
        <div class="laqm-item-title-tools white">
            <div class="laqm-item-tools">
            </div>
            <div class="laqm-item-title col-sm-3" data-id="<%=id%>" data-quiz_id="<%=quiz_id%>">
                <% if (user_id == 0) {%> Anonymous <%} else { %> <%=user_name%> <% } %>
            </div>
            <div class="laqm-item-title col-sm-4 ">
                <%=user_email%>
            </div>
            <div class="laqm-item-title col-sm-2  ">
                <%=score%>
            </div>
            <div class="laqm-item-title col-sm-3  ">
                <%=date_added%>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</script>