<?php

    /**
 * 投稿画面にカテゴリー選択用のメタボックスを追加する。
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
 * カテゴリー選択欄を表示する。
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
         * 選択したカテゴリーを保存する。
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
         * WordPress標準のカテゴリー選択欄を非表示にする。
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
         * Gutenberg標準のカテゴリー選択パネルを非表示にする。
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
         * 使用しない投稿機能を非表示にする。
         */
        function road_to_musha_remove_unused_post_supports()
        {
            remove_post_type_support('post', 'comments');
            remove_post_type_support('post', 'trackbacks');
    }
    add_action('init', 'road_to_musha_remove_unused_post_supports');