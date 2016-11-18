<?php
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormType extends AbstractType
{
	
	public static $categoriesMap = array(
			6 => 'Puokštės ir kompozicijos',
			7 => 'Gimtadienio puokštės',
			9 => 'Vestuvių puokštės',
			8 => 'Skintos gėlės',
			10 => 'Puokštės  į užsienį',
			11 => 'Dovanos ir  suvenyrai',
			12 => 'Populiariausios gėlės',
			13 => 'Sezoninės puokštės',
			14 => 'Motinos Dienos proga',
			15 => 'Rožės ',
			16 => 'Pristatymo paslaugos',
			17 => 'Kalėdinės  kompozicijos',
			18 => 'Valentino  dienai',
			19 => 'Akcijos',
			20 => 'Dovanos',
			21 => 'Bouquets and compositions',
			22 => 'Birthday Bouquets',
			23 => 'Wedding Bouquets',
			24 => 'Cut Flowers',
			27 => 'Most Popular',
			44 => 'Roses',
			28 => 'Seasonal Bouquets',
			29 => 'Services',
			30 => 'Christmas compositions',
			25 => 'Flowers abroad',
			26 => 'Gifts and Souvenirs',
			31 => 'Valentine\'s Day',
			32 => 'Special price',
			33 => 'Gifts',
			34 => 'Букеты и  композиции',
			45 => 'Цветы ко дню рождения ',
			35 => 'Ко дню матери',
			36 => 'Свадебные букеты',
			37 => 'Срезанные цветы',
			38 => 'Популярные  букеты',
			39 => 'Сезонные  букеты',
			40 => 'Рождественские  композиции',
			41 => 'Услуги',
			46 => 'Розы',
			42 => 'Скидки',
			43 => 'Подарки',
	);
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('sku', TextType::class, array(
				'label' => 'Sku'
		))
		->add('_category_id', ChoiceType::class, array(
				'choices'  => array_flip(self::$categoriesMap),
				'multiple' => true,
				'expanded' => true,
				'label' => 'Kategorijos',
				'label_attr' => array(
						'class' => 'checkbox-inline'
				)
		))
		->add('_product_websites', TextType::class, array(
				'label' => 'Produkto puslapis'
		))
		->add('description', TextareaType::class, array(
				'label' => 'Apibūnimas'
		))
		->add('image', TextType::class, array(
				'label' => 'Nuotraukos kelias'
		))
		->add('meta_description', TextareaType::class, array(
				'label' => 'Meta apibūnimas'
		))
		->add('name', TextType::class, array(
				'label' => 'Pavadinimas'
		))
		->add('short_description', TextareaType::class, array(
				'label' => 'Trumpas apibūnimas'
		))
		->add('small_image', TextType::class, array(
				'label' => 'Mažos nuotraukos kelias'
		))
		->add('thumbnail', TextType::class, array(
				'label' => 'Thumbnail'
		))
		->add('url_key', TextType::class, array(
				'label' => 'Url raktas'
		))
		->add('url_path', TextType::class, array(
				'label' => 'Url kelias'
		))
		->add('_media_image', TextType::class, array(
				'label' => 'Medijos paveikslo kelias'
		))
		->add('price', TextType::class, array(
				'label' => 'Pagrindinė kaina'
		))
		->add('didesnes_default_dydis_0', TextType::class, array(
				'label' => 'Defaultinis didesnės'
		))
		->add('didesnes_default_kaina_0', TextType::class, array(
				'label' => 'Defaultinė didesnės'
		))
		->add('dideles_default_dydis_1', TextType::class, array(
				'label' => 'Defaultinis didelės'
		))
		->add('dideles_default_kaina_1', TextType::class, array(
				'label' => 'Defaultinė didelės'
		))
		->add('ltu_didesnes_dydis_2', TextType::class, array(
				'label' => 'LTU didesnės'
		))
		->add('ltu_didesnes_kaina_2', TextType::class, array(
				'label' => 'LTU didesnės'
		))
		->add('ltu_dideles_dydis_3', TextType::class, array(
				'label' => 'LTU didelės'
		))
		->add('ltu_dideles_kaina_3', TextType::class, array(
				'label' => 'LTU didelės'
		))
		->add('en_didesnes_dydis_4', TextType::class, array(
				'label' => 'EN didesnės'
		))
		->add('en_didesnes_kaina_4', TextType::class, array(
				'label' => 'EN didesnės'
		))
		->add('en_dideles_dydis_5', TextType::class, array(
				'label' => 'EN didelės'
		))
		->add('en_dideles_kaina_5', TextType::class, array(
				'label' => 'EN didelės'
		))
		->add('ru_didesnes_dydis_6', TextType::class, array(
				'label' => 'RU didesnės'
		))
		->add('ru_didesnes_kaina_6', TextType::class, array(
				'label' => 'RU didesnės'
		))
		->add('ru_dideles_dydis_7', TextType::class, array(
				'label' => 'RU didelės'
		))
		->add('ru_dideles_kaina_7', TextType::class, array(
				'label' => 'RU didelės'
		))
		->add('insert', SubmitType::class)
		->add('update', SubmitType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'AppBundle\Entity\Variables',
		));
	}

	public function getName()
	{
		return 'update';
	}
}