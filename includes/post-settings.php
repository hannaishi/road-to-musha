<?php
    /**
 * 著者アーカイブへアクセスした場合はトップページへリダイレクトする。
 */
    function road_to_musha_redirect_author_archive()
    {
    if (is_author()) {
        wp_safe_redirect(home_url('/'));
        exit;
    }
    }
    add_action('template_redirect', 'road_to_musha_redirect_author_archive');

    /**
 * おすすめ記事を常に1件だけにする
 */
    function road_to_musha_keep_single_recommend($post_id)
    {
    // 投稿以外は対象外
    if ('post' !== get_post_type($post_id)) {
        return;
    }

    // 自動保存時は何もしない
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // 権限チェック
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    // この投稿がおすすめ記事ONでなければ終了
    $is_recommend = get_field('is_recommend', $post_id);

    if (! $is_recommend) {
        return;
    }

    // この投稿以外で、おすすめ記事ONの投稿を取得
    $recommend_posts = get_posts(
        [
            'post_type'      => 'post',
            'post_status'    => 'any',
            'posts_per_page' => -1,
            'post__not_in'   => [$post_id],
            'meta_query'     => [
                [
                    'key'     => 'is_recommend',
                    'value'   => '1',
                    'compare' => '=',
                ],
            ],
        ]
    );

    // 他のおすすめ記事をOFFにする
    foreach ($recommend_posts as $recommend_post) {
        update_field(
            'is_recommend',
            0,
            $recommend_post->ID
        );
    }
    }
    add_action('acf/save_post', 'road_to_musha_keep_single_recommend', 20);

    /**
 * 投稿画面にカテゴリー選択用のメタボックスを追加
 */
    function road_to_musha_add_category_meta_box()
    {
    add_meta_box(
        'road-to-musha-category',
        'カテゴリー',
        'road_to_musha_category_meta_box_callback',
        'post',
        'side',
        'high'
    );
    }
    add_action('add_meta_boxes', 'road_to_musha_add_category_meta_box');

    /**
 * カテゴリー選択欄を表示
 */
    function road_to_musha_category_meta_box_callback($post)
    {
    wp_nonce_field(
        'road_to_musha_save_category',
        'road_to_musha_category_nonce'
    );

    $categories = get_terms(
        [
            'taxonomy'   => 'category',
            'hide_empty' => false,
        ]
    );

    $selected_categories = wp_get_post_categories($post->ID);

    if (! empty($selected_categories)) {
        $selected_category = (int) $selected_categories[0];
    } elseif (! empty($categories)) {
        $selected_category = (int) $categories[0]->term_id;
    } else {
        $selected_category = 0;
    }
    ?>

    <p>カテゴリーを1つ選択してください。</p>

    <?php foreach ($categories as $category): ?>
        <p>
            <label>
                <input
                    type="radio"
                    name="road_to_musha_category"
                    value="<?php echo esc_attr($category->term_id); ?>"
                    <?php checked($selected_category, $category->term_id); ?>
                    required
                >
                <?php echo esc_html($category->name); ?>
            </label>
        </p>
    <?php endforeach; ?>

    <?php
        }

        /**
         * 選択したカテゴリーを保存
         */
        function road_to_musha_save_category($post_id)
        {
            if (
                ! isset($_POST['road_to_musha_category_nonce']) ||
                ! wp_verify_nonce(
                    $_POST['road_to_musha_category_nonce'],
                    'road_to_musha_save_category'
                )
            ) {
                return;
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if ('post' !== get_post_type($post_id)) {
                return;
            }

            if (! current_user_can('edit_post', $post_id)) {
                return;
            }

            if (! isset($_POST['road_to_musha_category'])) {
                return;
            }

            $category_id = absint($_POST['road_to_musha_category']);

            wp_set_post_categories(
                $post_id,
                [$category_id],
                false
            );
        }
        add_action('save_post', 'road_to_musha_save_category');

        /**
         * WordPress標準のカテゴリー選択欄を非表示
         */
        function road_to_musha_hide_default_category_panel()
        {
            // クラシックエディター用
            remove_meta_box(
                'categorydiv',
                'post',
                'side'
            );
        }
        add_action('admin_menu', 'road_to_musha_hide_default_category_panel');

        /**
         * Gutenberg標準のカテゴリー選択パネルを非表示
         */
        function road_to_musha_hide_gutenberg_category_panel()
        {
            wp_add_inline_script(
                'wp-edit-post',
                "
        wp.domReady(function () {
            wp.data.dispatch('core/edit-post').removeEditorPanel(
                'taxonomy-panel-category'
            );
        });
        "
            );
        }
        add_action(
            'enqueue_block_editor_assets',
            'road_to_musha_hide_gutenberg_category_panel'
        );
        /**
         * 使用しない投稿機能を非表示にする
         */
        function road_to_musha_remove_unused_post_supports()
        {
            remove_post_type_support('post', 'comments');
            remove_post_type_support('post', 'trackbacks');
        }
        add_action('init', 'road_to_musha_remove_unused_post_supports');
