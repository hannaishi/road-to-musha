<?php

/**
 * SEOタイトルをページごとに設定する。
 */
function road_to_musha_meta_title($title)
{
    // カテゴリー
    if (is_category()) {
        return '『' . single_cat_title('', false) . '』の記事一覧 | 武者への道';
    }

    // 日別アーカイブ
    if (is_day()) {
        return sprintf(
            '%d年%d月%d日の記事一覧 | 武者への道',
            get_query_var('year'),
            get_query_var('monthnum'),
            get_query_var('day')
        );
    }

    // 月別アーカイブ
    if (is_month()) {
        return sprintf(
            '%d年%d月の記事一覧 | 武者への道',
            get_query_var('year'),
            get_query_var('monthnum')
        );
    }

    // 年別アーカイブ
    if (is_year()) {
        return sprintf(
            '%d年の記事一覧 | 武者への道',
            get_query_var('year')
        );
    }

    // 検索結果
    if (is_search()) {
        return '『' . get_search_query() . '』の検索結果 | 武者への道';
    }

    // 記事詳細
    if (is_single()) {
        return '『' . get_the_title() . '』 | 武者への道';
    }

    return $title;
}
add_filter(
    'ssp_output_title',
    'road_to_musha_meta_title'
);

/**
 * SEOディスクリプションをページごとに設定する。
 */
function road_to_musha_meta_description($description)
{
    $top_description = '武者への道は駆け出しデザイナー・エンジニアを応援するメディアです。';

    // トップページ
    if (is_front_page()) {
        return $top_description;
    }

    // カテゴリー
    if (is_category()) {
        return '『' . single_cat_title('', false) . '』の記事一覧ページです。';
    }

    // 日別アーカイブ
    if (is_day()) {
        return sprintf(
            '%d年%d月%d日に更新した記事一覧ページです。',
            get_query_var('year'),
            get_query_var('monthnum'),
            get_query_var('day')
        );
    }

    // 月別アーカイブ
    if (is_month()) {
        return sprintf(
            '%d年%d月に更新した記事一覧ページです。',
            get_query_var('year'),
            get_query_var('monthnum')
        );
    }

    // 年別アーカイブ
    if (is_year()) {
        return sprintf(
            '%d年に更新した記事一覧ページです。',
            get_query_var('year')
        );
    }

    // 検索結果
    if (is_search()) {
        return $top_description;
    }

    // 404
    if (is_404()) {
        return $top_description;
    }

    return $description;
}
add_filter(
    'ssp_output_description',
    'road_to_musha_meta_description'
);
