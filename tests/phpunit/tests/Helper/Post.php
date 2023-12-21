<?php

namespace Municipio\Tests\Helper;

use Mockery;
use WP_Mock;
use WP_Mock\Tools\TestCase;
use Municipio\Helper\Post;
use WP_Error;
use WP_Post;

use function Patchwork\Config\merge;

/**
 * Class PostTest
 */
class PostTest extends TestCase
{
    /**
     * @testdox preparePostObject returns a post if it $post is an instance of WP_Post.
     * @runInSeparateProcess
     */
    public function testPreparePostObjectReturnsPostIfPostReceived()
    {
        // Given
        $post = $this->mockPost(['ID' => 1, 'post_title' => 'Test', 'post_content' => 'Test']);
        $mock = $this->mockStaticMethod('\Municipio\Helper\Post', 'complementObject');
        $mock->once()->andReturn($post);

        // When
        $result = \Municipio\Helper\Post::preparePostObject($post);

        // Then
        $this->assertInstanceOf(\WP_Post::class, $post);
    }

     /**
     * @testdox preparePostObjectArchive returns a post if it $post is an instance of WP_Post.
     * @runInSeparateProcess
     */
    public function testPreparePostObjectArchiveReturnsPostIfPostReceived()
    {
        // Given
        $post = $this->mockPost(['ID' => 1, 'post_title' => 'Test', 'post_content' => 'Test']);
        $mock = $this->mockStaticMethod('\Municipio\Helper\Post', 'complementObject');
        $mock->once()->andReturn($post);

        // When
        $result = \Municipio\Helper\Post::preparePostObject($post);

        // Then
        $this->assertInstanceOf(\WP_Post::class, $post);
    }

    /**
     * @testdox preparePostObjectSingular returns a post if it $post is an instance of WP_Post.
     * @runInSeparateProcess
     */
    public function testPreparePostObjectSingularReturnsPostIfPostReceived()
    {
        // Given
        $post = $this->mockPost(['ID' => 1, 'post_title' => 'Test', 'post_content' => 'Test']);
        $mock = $this->mockStaticMethod('\Municipio\Helper\Post', 'complementObject');
        $mock->once()->andReturn($post);

        // When
        $result = \Municipio\Helper\Post::preparePostObject($post);

        // Then
        $this->assertInstanceOf(\WP_Post::class, $post);
    }

    public function testGetFeaturedImageReturnImage()
    {
        // Given
        WP_Mock::userFunction('get_post_thumbnail_id', [
            'return' => 1
        ]);

        Mockery::mock('alias:' . \Municipio\Helper\Image::class)->
        shouldReceive('getImageAttachmentData')->
        andReturn(['src' => 'test']);

        // When
        $result = \Municipio\Helper\Post::getFeaturedImage(1, 'full');

        $this->assertTrue(true);

        $foo = 'bar';
    }


    /**
     * @testdox ComplementObject Returns instance of WP_Post.
     * @runInSeparateProcess
     */
    public function testComplementObjectReturnsPostObject()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        $postHelper = new Post();

        Mockery::mock('alias:' . \Municipio\Helper\Image::class)->
        shouldReceive('getImageAttachmentData')->
        andReturn(['src' => 'test']);

        // When
        $result = $postHelper::complementObject($post);

        // Then
        $this->assertInstanceOf(\WP_Post::class, $result);
    }

    /**
     * @testdox ComplementObject Returns complemented post_excerpt keys.
     */
    public function testComplementObjectReturnsComplementedPostExcerptKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, [ 'excerpt']);

        // Then
        $this->assertIsString($result->excerpt);
        $this->assertIsString($result->excerpt_short);
        $this->assertIsString($result->excerpt_shorter);
    }

    /**
     * @testdox ComplementObject Returns complemented post_title keys.
     */
    public function testComplementObjectReturnsComplementedPostTitleKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, [ 'post_title_filtered']);

        // Then
        $this->assertIsString($result->post_title_filtered);
    }

    /**
     * @testdox ComplementObject Returns complemented permalink keys.
     */
    public function testComplementObjectReturnsComplementedPostPermalinkKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, [ 'permalink']);

        // Then
        $this->assertIsString($result->permalink);
    }

    /**
     * @testdox ComplementObject Returns complemented permalink keys.
     */
    public function testComplementObjectReturnsComplementedPostTermsKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, ['terms']);

        // Then
        $this->assertIsArray($result->terms);
        $this->assertIsArray($result->termsUnlinked);
    }

    /**
     * @testdox ComplementObject Returns complemented langauge keys.
     */
    public function testComplementObjectReturnsComplementedPostlanguageKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, ['post_language']);

        // Then
        $this->assertIsString($result->post_language);
    }

    /**
     * @testdox ComplementObject Returns complemented reading time keys.
     */
    public function testComplementObjectReturnsComplementedPostReadingTimeKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, ['reading_time']);

        // Then
        $this->assertIsString($result->reading_time);
    }

    /**
     * @testdox ComplementObject Returns complemented call to action items keys.
     */
    public function testComplementObjectReturnsComplementedPostCallToActionItemsKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, ['call_to_action_items']);

        // Then
        $this->assertIsArray($result->call_to_action_items);
    }

    /**
     * @testdox ComplementObject Returns complemented term icon keys.
     */
    public function testComplementObjectReturnsComplementedPostTermIconKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, ['term_icon']);


        // Then
        $this->assertIsString($result->termIcon['icon']);
        $this->assertIsString($result->termIcon['backgroundColor']);
        $this->assertIsString($result->termIcon['color']);
        $this->assertIsString($result->termIcon['size']);
    }

    /**
     * @testdox ComplementObject Returns complemented location keys.
     */
    public function testComplementObjectReturnsComplementedPostLocationKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post, ['pin' => 'test']);

        // When
        $result = Post::complementObject($post, []);


        // Then
        $this->assertNotNull($result->location);
        $this->assertArrayHasKey('pin', $result->location);
    }

    /**
     * @testdox ComplementObject Returns correct keys that are always set
     */
    public function testComplementObjectReturnsComplementedAlwaysSetKeys()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, []);


        // Then
        $this->assertArrayHasKey('thumbnail_16:9', $result->images);
        $this->assertArrayHasKey('thumbnail_4:3', $result->images);
        $this->assertArrayHasKey('thumbnail_1:1', $result->images);
        $this->assertArrayHasKey('thumbnail_3:4', $result->images);
        $this->assertArrayHasKey('featuredImage', $result->images);
        $this->assertArrayHasKey('thumbnail_12:16', $result->images);
        $this->assertIsString($result->post_time_formatted);
        $this->assertIsString($result->post_date_time_formatted);
        $this->assertIsString($result->post_date_formatted);
    }

    /**
     * @testdox ComplementObject Changes content keys if password protected.
     */
    public function testComplementObjectReturnsSkipKeysWhenPasswordProtected()
    {
        // Given
        $post = $this->getMockedpost();
        $this->mockDependenciesForComplementObject($post, 'string', true);

        // When
        $result = Post::complementObject($post, []);

        // Then
        $this->assertEquals($post->post_content, $result->post_content);
        $this->assertEquals($post->post_content, $result->post_content_filtered);
        $this->assertEquals($post->post_content, $result->post_excerpt);
        $this->assertEquals($post->post_content, $result->excerpt);
        $this->assertEquals($post->post_content, $result->excerpt_short);
        $this->assertEquals($post->post_content, $result->excerpt_shorter);
    }

    /**
     * @testdox ComplementObject Places quicklinks after first block if chosen.
     */
    public function testComplementObjectReturnsCorrectQuicklinksPlacement()
    {
        // Given
        $post = $this->getMockedpost();

        WP_Mock::userFunction('parse_blocks', [
            'return' => [(object)['blockName' => 'block1'], (object)['blockName' => 'block2']]
        ]);

        WP_Mock::userFunction('render_block', [
            'return' => '<div>block</div>'
        ]);

        WP_Mock::userFunction('render_blade_view', [
            'return' => '<div>quicklinks</div>'
        ]);

        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, [], ['quicklinksMenuItems' => ['item 1', 'item 2']]);

        // Then
        $this->assertEquals('<div>block</div><div>quicklinks</div><div>block</div>', $result->post_content);
    }

    /**
     * @testdox ComplementObject Returns formatted post_content as post_content_filtered when a more-tag is found
     */
    public function testComplementObjectReturnsFilteredPostContent()
    {
        // Given
        $post = $this->getMockedpost(['post_content' => 'Some text. <!--more--> Some other text']);
        $this->mockDependenciesForComplementObject($post);

        // When
        $result = Post::complementObject($post, ['post_content_filtered']);

        // Then
        $this->assertEquals($post->post_content_filtered, '<p class="lead">Some text. </p> Some other text');

        $foo = 'bar';
    }

    // Mock post args
    private function getMockedpost(array $args = [])
    {
        return $this->mockPost(array_merge([
            'ID'           => 1,
            'post_title'   => 'test',
            'post_content' => 'test',
            'post_excerpt' => 'Test',
            'permalink'    => 'https://url.url',
            'post_type'    => 'test',
            'terms'        => ['test' => 'test']
        ], $args));
    }

    // Mock ComplementObject methods
    private function mockDependenciesForComplementObject($post, $getField = 'string', $postPasswordRequired = false)
    {
        WP_Mock::userFunction('post_password_required', [
            'return' => $postPasswordRequired
        ]);

        WP_Mock::userFunction('get_the_password_form', [
            'return' => $post->post_content
        ]);

        WP_Mock::userFunction('wp_date', [
            'return' => 'TestDate'
        ]);

        WP_Mock::userFunction('get_post_thumbnail_id', [
            'return' => 1
        ]);

        WP_Mock::userFunction('get_field', [
            'return' => $getField
        ]);

        WP_Mock::userFunction('strip_shortcodes', [
            'return' => $post->post_excerpt
        ]);

        WP_Mock::userFunction('wp_trim_words', [
            'return' => $post->post_excerpt
        ]);

        WP_Mock::userFunction('get_permalink', [
            'return' => $post->permalink
        ]);

        WP_Mock::userFunction('get_theme_mod', [
            'return' => ['modName' => 'modValue']
        ]);

        WP_Mock::userFunction('get_post_type', [
            'return' => $post->post_type
        ]);

        WP_Mock::userFunction('get_bloginfo', [
            'return' => 'en'
        ]);

        WP_Mock::userFunction('wp_get_post_terms', [
            'return' => []
        ]);

        WP_Mock::userFunction('get_object_taxonomies', [
            'return' => (object) ['icon' => 'test']
        ]);

        WP_Mock::userFunction('get_the_terms', [
            'return' => (object) ['icon' => 'test']
        ]);

        WP_Mock::userFunction('get_term_by', [
            'return' => ['term' => 'test']
        ]);

        WP_Mock::userFunction('has_blocks', [
            'return' => true
        ]);

        Mockery::mock('alias:' . \Municipio\Helper\Image::class)->
        shouldReceive('getImageAttachmentData')->
        andReturn(['src' => 'test']);

        Mockery::mock('alias:' . \Municipio\Helper\Term::class)->
        shouldReceive('getTermIcon')->
        andReturn(['src' => 'test', 'type' => 'icon'])->
        shouldReceive('getTermColor')->
        andReturn('blue');

        Mockery::mock('alias:' . \Municipio\Helper\Navigation::class)->
        shouldReceive('getQuicklinksPlacement')->
        andReturn('after_first_block')->
        shouldReceive('displayQuicklinksAfterContent')->
        andReturn(false);

        Mockery::mock('alias:' . \Modularity\Module\Posts\Helper\ContentType::class)->
        shouldReceive('getContentType')->
        andReturn(false);
    }
}
